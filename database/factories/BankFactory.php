<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bank>
 */
class BankFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'transaction_id' => Transaction::factory(),
            'payment_id' => Payment::factory(),
            'transaction_acccount_name' => $this->faker->name,
            'transaction_acccount_number' => $this->faker->bankAccountNumber,
            'transaction_recipt' => $this->faker->imageUrl(),
            'transaction_date' => $this->faker->dateTimeBetween('-1 years', 'now')->format('Y-m-d'),
        ];
    }
}
