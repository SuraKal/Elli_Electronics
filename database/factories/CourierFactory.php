<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Courier>
 */
class CourierFactory extends Factory
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
            'name' => $this->faker->company,
            'contact_phone' => $this->faker->phoneNumber,
            'contact_email' => $this->faker->unique()->safeEmail,
            'address' => $this->faker->address,
            'description' => $this->faker->sentence(10),
            'status' => $status,
            'logo' => NULL
        ];
    }
}
