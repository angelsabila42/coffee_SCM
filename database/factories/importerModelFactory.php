<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\importerModel>
 */
class importerModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=> fake()->name(),
            'email'=> fake()->email(),
            'country'=> fake()->country(),
            'phone_number'=> fake()->phoneNumber(),
            'address'=> fake()->address(),
            'Bank_account' => fake()->bankAccountNumber(),
            'Account_holder' => fake()->name(),
            'Bank_name' => fake()->company()
        ];
    }
}
