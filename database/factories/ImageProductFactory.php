<?php

namespace Database\Factories;

use App\Models\ImageProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ImageProduct>
 */
class ImageProductFactory extends Factory
{
    protected $model = ImageProduct::class;

    public function definition()
    {
        return [
            'idPro' => null, // Sẽ được điền sau khi liên kết với Product
            'image' => $this->faker->numberBetween(1, 9999999999) . '.jpg', // Tên file ảnh giả
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
