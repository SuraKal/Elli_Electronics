<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Setting>
 */
class SettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'contact_phone' => $this->faker->phoneNumber,
            'contact_email' => $this->faker->safeEmail,
            'address' => $this->faker->address,
            'logo' => $this->faker->imageUrl(600, 400, 'nature')
        ];
    }
}
