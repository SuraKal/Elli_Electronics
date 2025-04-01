<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = $this->faker->boolean(60);
        return [
            'method' => $this->faker->unique()->word,
            'logo' => $this->faker->imageUrl(),
            'acc_name' => $this->faker->name,
            'acc_number' => $this->faker->bankAccountNumber,
            'status' => $status,
        ];

        // $table->string('method')->unique()->index();
        //     $table->string('logo')->nullable();
        //     $table->string('acc_name')->index();
        //     $table->string('acc_number')->index();
        //     $table->enum('status', ['active', 'inactive'])->default('active')->index(); // Frequently filtered
    }
}
