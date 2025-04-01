<?php

namespace Database\Factories;

use App\Models\Corporate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'corporate_id' => Corporate::factory(), // Create or link to an existing Corporate
            'name' => $this->faker->company . ' Project', // Fake project name
            'description' => $this->faker->paragraph(), // Random description
            'status' => $this->faker->randomElement(['pending', 'approved', 'in-progress', 'declined', 'completed']), // Random status
        ];
    }
}
