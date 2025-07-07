<?php

namespace Database\Factories;
use App\Models\Invoice;
use App\Models\importerModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class paymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'receipt_number' => $this->faker->unique()->numerify('REC-#####'),
            'invoice_id' => Invoice::inRandomOrder()->first()?->id, 
            'payer' => $this->faker->name(),
            'amount_paid' => $this->faker->randomFloat(2, 100, 10000),
            'date_paid' => $this->faker->dateTimeThisYear(),
            'payment_mode' => $this->faker->randomElement(['Cash', 'Bank Transfer', 'Mobile Money']),
            'status' => $this->faker->randomElement(['Pending', 'Completed', 'partial']),
            'coffee_type' => $this->faker->randomElement(['Arabicca', 'Robusta']),
            'payment_description' => $this->faker->sentence(),
            'recipient_name' => $this->faker->name(),
            'receipt_file_path' => $this->faker->filePath(),
          'importerID' => importerModel::inRandomOrder()->first()?->id,
  ];
    }
}
