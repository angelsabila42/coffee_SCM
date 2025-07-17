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
            'password'=> fake()->password(),
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
            'country'=> fake()->country(),
            'continent'=> fake()->country(),
            'phone_number'=> fake()->phoneNumber(),
            'address'=> fake()->address(),
            
            
          
        ];
    }
}
