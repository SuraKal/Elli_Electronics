<?php

namespace Database\Factories;

use App\Models\Corporate;
use App\Models\Guest;
use App\Models\Product;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
                        // Randomly select the user type
        $userType = $this->faker->randomElement(['guest', 'customer', 'corporate']);

        // Initialize variables for related models
        $guest_id = null;
        $user_id = null;
        $corporate_id = null;

        $is_project_order = false;
        $project_id = null;

        $type = 'BePaid';

        // Handle different user types and create related models
        if ($userType == 'guest') {
            // Create a Guest and assign its ID
            $guest = Guest::factory()->create();
            $guest_id = $guest->id;

        } elseif ($userType == 'customer') {
            // Create a User and assign its ID
            $user = User::factory()->create();
            $user_id = $user->id;

        } elseif ($userType == 'corporate') {
            // Create a User
            $user = User::factory()->create();
            $user_id = $user->id;

            // Create a Corporate linked to the user
            $corporate = Corporate::factory()->create(
                [
                'user_id' => $user_id,
                    ]
            );
            $corporate_id = $corporate->id;
        }

        if($userType == 'corporate'){
            // Decide whether the user has a project wish

            // $is_project_order = $this->faker->boolean();
            // For now 
            $is_project_order = false;
            // Create a Project if there's a project wish, otherwise null
            $project_id = $is_project_order ? Project::factory()->create()->id : null;

            $type = $this->faker->randomElement(['Credit', 'BePaid']);
        }


        return [
            'guest_id' => $guest_id,
            'user_id' => $user_id,
            'corporate_id' => $corporate_id,
            'is_project_order' =>  $is_project_order,
            'project_id' => $project_id,
            'userType' => $userType,
            'product_id' => Product::factory(),
            'type' => $type,
            'status' => $this->faker->randomElement(['pending','assigned','cancelled','ontheway','dropped']),
        ];
    }
}
