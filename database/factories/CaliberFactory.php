<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Caliber>
 */
class CaliberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'caliber_code' => 'Clb0-' . $this->faker->unique()->numberBetween(1, 10),
            'caliber_name' => $this->faker->unique()->text(5),
            'product_id'   => Product::inRandomOrder()->first()->id,
            "box_quantity" => $this->faker->numberBetween(2, 5),
        ];
    }
}
