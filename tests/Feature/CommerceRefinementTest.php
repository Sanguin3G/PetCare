<?php
namespace Tests\Feature;

use App\Jobs\ProcessCheckOut;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class CommerceRefinementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // These tests exercise commerce authorization, not Passport key provisioning.
        config(['auth.guards.api.driver' => 'session']);
    }

    private function product(): Product
    {
        $category = Category::create(['name' => 'Food']);
        return Product::factory()->create(['idCat' => $category->idCat, 'cost' => 100000, 'discount' => 10, 'count' => 5]);
    }

    private function checkout(Product $product, int $count = 2): array
    {
        return ['Name' => 'Customer', 'Phone' => '0912345678', 'Address' => '12 Pet Street', 'Method_Payment' => 'cod',
            'Total' => 1, 'DiscountVoucher' => 99, 'Cart' => [['idPro' => $product->idPro, 'count' => $count, 'cost' => 1]]];
    }

    public function test_checkout_uses_server_price_stock_and_discount_snapshot(): void
    {
        Queue::fake();
        $user = User::factory()->create(['role' => 'user']);
        $product = $this->product();
        $this->actingAs($user, 'api')->postJson('/api/user/cart/checkout', $this->checkout($product))->assertOk();
        $order = Order::firstOrFail();
        $this->assertSame(3, $product->fresh()->count);
        $this->assertEquals(100000, OrderDetail::first()->price);
        $this->assertEquals(180000, $order->getTotalCostOfOrder($order->id));
        $product->discount = 50;
        $product->cost = 500000;
        $product->save();
        $this->assertEquals(180000, $order->getTotalCostOfOrder($order->id));
        Queue::assertPushed(ProcessCheckOut::class);
    }

    public function test_checkout_rejects_insufficient_stock_without_creating_an_order(): void
    {
        Queue::fake();
        $user = User::factory()->create(['role' => 'user']);
        $product = $this->product();
        $this->actingAs($user, 'api')->postJson('/api/user/cart/checkout', $this->checkout($product, 6))->assertUnprocessable()->assertJsonValidationErrors('Cart');
        $this->assertSame(0, Order::count());
        $this->assertSame(5, $product->fresh()->count);
    }

    public function test_pending_order_cancellation_restores_stock_only_once(): void
    {
        Queue::fake();
        $user = User::factory()->create(['role' => 'user']);
        $product = $this->product();
        $this->actingAs($user, 'api')->postJson('/api/user/cart/checkout', $this->checkout($product))->assertOk();
        $id = Order::firstOrFail()->id;
        $this->patchJson("/api/user/order/$id/cancel")->assertOk();
        $this->patchJson("/api/user/order/$id/cancel")->assertUnprocessable();
        $this->assertSame(5, $product->fresh()->count);
        $this->assertSame(-1, Order::first()->status);
    }

    public function test_order_cancellation_cannot_target_another_customers_order(): void
    {
        Queue::fake();
        $owner = User::factory()->create(['role' => 'user']);
        $product = $this->product();
        $this->actingAs($owner, 'api')->postJson('/api/user/cart/checkout', $this->checkout($product))->assertOk();
        $id = Order::firstOrFail()->id;
        $other = User::factory()->create(['role' => 'user']);
        $this->actingAs($other, 'api')->patchJson("/api/user/order/$id/cancel")->assertNotFound();
        $this->assertSame(3, $product->fresh()->count);
    }
}
