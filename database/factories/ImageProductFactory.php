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
            'image' => $this->faker->randomElement([
                '11744188936.webp',
                '11744188980.webp',
                '11744189056.webp',
                '11744189111.webp',
                '11744189172.jpg',
                '11744353792.webp',
                '11744603335.jpg',
                '11744603398.webp',
                '11744768386.webp',
                '11744768508.webp',
                '11744768615.webp',
                '21744768508.webp',
            ]),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
