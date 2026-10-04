<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogueRefinementTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_catalogue_filters_and_sorts_by_discounted_price(): void
    {
        $category = Category::create(['name' => 'Food']);
        $other = Category::create(['name' => 'Toys']);
        Product::factory()->create(['idCat' => $category->idCat, 'namePro' => 'Food Premium', 'cost' => 200, 'discount' => 75]);
        Product::factory()->create(['idCat' => $category->idCat, 'namePro' => 'Food Basic', 'cost' => 100, 'discount' => 0]);
        Product::factory()->create(['idCat' => $other->idCat, 'namePro' => 'Toy Ball']);

        $this->get('/product/all?category='.$category->idCat.'&q=Food&sort=price-asc')
            ->assertOk()->assertSeeInOrder(['Food Premium', 'Food Basic'])->assertDontSee('Toy Ball');
        $this->get('/product/'.$category->idCat)->assertOk();
    }

    public function test_search_is_public_bounded_and_handles_missing_images(): void
    {
        $category = Category::create(['name' => 'Food']);
        Product::factory()->count(9)->create(['idCat' => $category->idCat, 'namePro' => 'Pet Food', 'cost' => 200, 'discount' => 25]);
        $response = $this->getJson('/api/products/search?q=Pet');
        $response->assertOk()->assertJsonCount(6, 'data')->assertJsonPath('data.0.price', 150);
        $this->assertStringContainsString('PetCARE.png', $response->json('data.0.image'));
        $this->getJson('/api/products/search?q=P')->assertOk()->assertJsonCount(0, 'data');
        $this->getJson('/api/user/product?field=invalid')->assertUnprocessable();
    }

    public function test_empty_catalogue_and_missing_product_are_handled(): void
    {
        $this->get('/product/all')->assertOk()->assertSee('Chưa tìm thấy sản phẩm');
        $this->get('/product/detail/NOTFOUND/product')->assertNotFound();
    }
}
