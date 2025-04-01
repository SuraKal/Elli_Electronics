<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = ['admin', 'sub_admin', 'customer', 'cooprate'];
        return [
            'name' => $this->faker->randomElement($name),
            'description' => $this->faker->sentence(),
        ];
    }
}
