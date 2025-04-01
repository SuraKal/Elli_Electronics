<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Template>
 */
class TemplateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = $this->faker->boolean(90);

        return [
            'name' => $this->faker->name(),
            'note' => $this->faker->sentence(),
            'structure' => json_encode([
                'Color' => [
                    'Red' => $this->faker->randomElement(['active', 'inactive']),
                    'Blue' => $this->faker->randomElement(['active', 'inactive']),
                    'Green' => $this->faker->randomElement(['active', 'inactive']),
                    'Black' => $this->faker->randomElement(['active', 'inactive']),
                    'Yellow' => $this->faker->randomElement(['active', 'inactive']),
                    'White' => $this->faker->randomElement(['active', 'inactive']),
                ],
                'Size' => [
                    'Small' => $this->faker->randomElement(['active', 'inactive']),
                    'Medium' => $this->faker->randomElement(['active', 'inactive']),
                    'Large' => $this->faker->randomElement(['active', 'inactive']),
                    'XL' => $this->faker->randomElement(['active', 'inactive']),
                    'XXL' => $this->faker->randomElement(['active', 'inactive']),
                ],
            ]),
            'status' => $status
        ];
    }
}
