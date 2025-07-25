<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

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
         //   'password' => Hash::make('password'),
            'email'=> fake()->email(),
            'Bank_account' => fake()->bankAccountNumber(),
            'Account_holder'=> fake()->name(),
            'Bank_name'=> fake()->randomElement([
                                'Stanbic Bank Uganda',
                                'Centenary Bank',
                                'DFCU Bank',
                                'Equity Bank',
                                'ABSA Uganda',
                                'Bank of Africa',
                                'PostBank Uganda',
                            ]),
            'phone_number'=> fake()->phoneNumber(),
            'region' => fake()->randomElement(['Western','Central', 'Eastern', 'Ankole']),
            'street'=> fake()->streetName(),
            'city'=> fake()->city(),        
        ];
    }
}
