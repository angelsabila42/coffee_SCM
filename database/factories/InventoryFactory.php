<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\inventory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\inventory>
 */
class InventoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'coffee_type'=> fake()->randomElement(['Arabica','Robusta']),
            'grade'=> fake()->randomElement(['A', 'B', 'C']),
            'warehouse_name'=> fake()->company(),
            'quantity'=> fake()->numberBetween(100,1000),
            'threshold'=> fake()->numberBetween(50,100),
            'status'=> fake()->randomElement(['in stock','low',]), 
            'last_updated'=> fake()->date()
        ];
    }
}
