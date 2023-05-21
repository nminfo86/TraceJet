<?php

namespace Database\Factories;

use App\Models\Section;
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
    public function definition()
    {
        return [
            'product_code' => 'P' . $this->faker->unique()->numberBetween(1, 150),
            'product_name' => $this->faker->name,
            'section_id' => Section::inRandomOrder()->first()->id,
        ];
        // return [
        //     'product_code' => "1071000",
        //     'product_name' => "Contacteur",
        //     'section_id' => 1,
        // ];
    }
}
