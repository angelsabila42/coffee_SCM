<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SalesReport>
 */
class SalesReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'start_period'=> fake()->dateTimeBetween('-1 year', '-6 months')->format('Y-m-d'),
            'end_period'=> fake()->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
            //
        ];
    }
}
