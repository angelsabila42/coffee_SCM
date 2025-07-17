<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\vendor>
 */
class VendorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone_number' => fake()->phoneNumber(),
            'street' => fake()->streetName(),
            'city' => fake()->city(),
            'Bank_account' => fake()->numerify('###########'),
            'Account_holder' => fake()->name(),
            'Bank_name' => fake()->company(),
        ];
    }
}
