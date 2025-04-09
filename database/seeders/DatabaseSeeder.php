<?php

namespace Database\Seeders;

use App\Models\ImageProduct;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // Tạo 50 sản phẩm, mỗi sản phẩm có 1-3 ảnh
        Product::factory()
            ->count(10)
            // ->has(ImageProduct::factory()->count(rand(1, 3)))
            ->create();
    }
}
