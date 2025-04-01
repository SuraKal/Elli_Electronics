<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Guest;
use App\Models\Corporate;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shipping>
 */
class ShippingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userType = $this->attributes['userType'] ?? $this->faker->randomElement(['guest', 'customer']);
                                // Randomly select the user type
        // $userType = $this->faker->randomElement(['guest', 'customer']);

        // Initialize variables for related models
        $guest_id = null;
        $user_id = null;
        $corporate_id = null;



        // Handle different user types and create related models
        if ($userType == 'guest') {
            // Create a Guest and assign its ID
            $guest = Guest::factory()->create();
            $guest_id = $guest->id;

        } elseif ($userType == 'customer') {
            // Create a User and assign its ID
            $user = User::factory()->create();
            $user_id = $user->id;
        } 
        
        return [
            'guest_id' => $guest_id,
            'user_id' => $user_id,
            'order_id' => Order::factory()->create()->id,
            'userType' => $userType,
            'email' => $this->faker->unique()->safeEmail(),
            'name' => $this->faker->name(),
            'phone' => $this->faker->optional()->phoneNumber(),
            'tax_id' => $this->faker->optional()->bothify('??-########'), // Example tax ID format
            'address' => $this->faker->streetAddress(),
            'appartment' => $this->faker->optional()->secondaryAddress(),
            'country' => 'Ethiopia',
            'city' => $this->faker->city(),
            'zip' => $this->faker->postcode(),
        ];
    }
}
