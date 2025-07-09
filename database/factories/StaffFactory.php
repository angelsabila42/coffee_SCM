<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StaffFactory extends Factory
{
    public function definition(): array
    {
        return [
            
            'full_name' => substr($this->faker->name(), 0, 20),
            'role' => $this->faker->randomElement(['Logistics Supervisor', 'Sales Manager', 'Supervisor', 'QA']),
            'status' => $this->faker->randomElement(['Active', 'On Leave', 'Suspended']),
            'phone_number' => $this->faker->numerify('07########'),
            'email' => $this->faker->unique()->safeEmail(),
        ];
    }
}
