<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PetCareTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_homepage_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertOk();
    }

    public function test_the_application_is_named_petcare(): void
    {
        $this->assertSame('PetCare', config('app.name'));
    }

    public function test_the_homepage_handles_a_product_without_an_image(): void
    {
        $category = Category::create(['name' => 'Test category']);
        Product::factory()->create(['idCat' => $category->idCat]);

        $this->get('/')->assertOk();
    }

    public function test_the_demo_seed_contains_varied_petcare_catalog_data(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertSame(6, Category::count());
        $this->assertSame(12, Product::count());
        foreach (Product::with('ImageProduct')->get() as $product) {
            $this->assertTrue($product->ImageProduct->isNotEmpty());
        }
        $this->assertGreaterThan(1, Product::query()->distinct('idCat')->count('idCat'));
        $this->assertGreaterThan(1, Product::query()->distinct('discount')->count('discount'));
        $this->seed(DatabaseSeeder::class);
        $this->assertSame(12, Product::count());
        $glove = Product::with('ImageProduct')->where('namePro', 'Găng tay chải lông thú cưng')->firstOrFail();
        $this->assertSame(3, $glove->ImageProduct->count());
    }

    public function test_public_pages_expose_the_petcare_theme_switcher(): void
    {
        foreach (['/', '/about', '/login', '/register', '/forgetPass'] as $url) {
            $response = $this->get($url)
                ->assertOk()
                ->assertSee('data-theme-choice="dark"', false)
                ->assertSee('/build/assets/petcare-', false);

            if ($url === '/') {
                $response
                    ->assertSee('id="offcanvasNavbar"', false)
                    ->assertSee('data-product-search', false)
                    ->assertDontSee('id="collapseButton"', false);
            }
        }
    }
}
