<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Product::class;
    public function definition(): array
    {
        return [
            // 'idPro' không cần định nghĩa vì đã được tạo trong boot()
            'namePro' => $this->faker->words(3, true), // Tạo tên sản phẩm (3 từ)
            'description' => $this->faker->paragraph(), // Tạo đoạn mô tả ngẫu nhiên
            'count' => $this->faker->numberBetween(1, 100), // Số lượng từ 1 đến 100
            'hot' => $this->faker->boolean(20), // 20% cơ hội là 1 (nổi bật), 80% là 0
            'cost' => $this->faker->numberBetween(10000, 1000000), // Giá từ 10,000 đến 1,000,000 VND
            'discount' => $this->faker->numberBetween(0, 50), // Giảm giá từ 0% đến 50%
            'idCat' => 1, // Giả sử có 5 danh mục (1-5)
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'), // Thời gian tạo trong 1 năm qua
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'), // Thời gian cập nhật
        ];
    }
}
