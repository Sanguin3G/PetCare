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
            'image' => '11744768508.webp', // Existing demo image in public/assets/img-add-pro
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
