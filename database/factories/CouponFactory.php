<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
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
            'name' => $this->faker->name(),
            'discount_value' => $this->faker->randomFloat(2, 0, 100),
            'usage_limit' => $this->faker->numberBetween(1, 30),
            'used_count' => $this->faker->numberBetween(0, 30),
            'expires_at' => $this->faker->dateTimeBetween('now', '+1 year')->format('Y-m-d H:i'),

            'status' => $status,
        ];
    }
}
