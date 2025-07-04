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
            'name'=> fake()->name(),
            'password'=> fake()->password(),
            'email'=> fake()->email(),
            'phone_number'=> fake()->phoneNumber(),
            'street'=> fake()->streetName(),
            'city'=> fake()->city(),        
        ];
    }
}
