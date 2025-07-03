<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Vendor;
use App\Models\WorkCenter;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OutgoingOrder>
 */
class OutgoingOrderFactory extends Factory
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
            'status'=> fake()->randomElement(['Pending','Confirmed','Delivered','Requested','Declined']),
            'deadline'=> fake()->dateTimeBetween('now','+2 weeks'),
            'coffeeType'=> fake()->randomElement(['Arabica','Robusta']),
            'vendor_id'=> Vendor::inRandomOrder()->first()->id,
            'work_center_id'=> WorkCenter::inRandomOrder()->first()->id,
        ];
    }
}
