<?php

namespace Database\Factories;

use App\Models\importerModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\IncomingOrder>
 */
class IncomingOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quantity'=> fake()->numberBetween(100,1000),
            'status'=> fake()->randomElement(['Pending','Confirmed','Delivered','Requested','Cancelled']),
            'deadline'=> fake()->dateTimeBetween('now','+2 weeks'),
            'grade'=> fake()->randomElement(['A','B', 'C', 'screen 8']),
            'coffeeType'=> fake()->randomElement(['Arabica','Robusta']),
            'destination'=> fake()->country(),
            'importer_model_id'=> importerModel::inRandomOrder()->first()->id,
        ];
    }
}
