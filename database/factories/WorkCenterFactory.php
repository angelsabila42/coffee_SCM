<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkCenter>
 */
class WorkCenterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
              'workCenterID' => fake()->unique()->uuid(),
           'location'=> fake()->city(),
           'centerName'=>fake()->company(),
        ];
    }
}
