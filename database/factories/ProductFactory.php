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
            'namePro' => $this->faker->randomElement([
                'Bánh thưởng thịt gà cho chó',
                'Cát mèo khử mùi dịu nhẹ',
                'Đồ chơi dây thừng bện chắc',
                'Sữa tắm yến mạch cho thú cưng',
            ]),
            'description' => $this->faker->randomElement([
                'Sản phẩm tiện dụng, dễ dùng và được chọn để chăm sóc thú cưng mỗi ngày.',
                'Công thức dịu nhẹ, phù hợp cho những buổi chăm sóc tại nhà thật thoải mái.',
            ]),
            'count' => $this->faker->numberBetween(5, 60),
            'hot' => $this->faker->boolean(25),
            'cost' => $this->faker->numberBetween(49000, 650000),
            'discount' => $this->faker->randomElement([0, 0, 10, 15, 20]),
            'idCat' => 1,
            'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ];
    }
}
