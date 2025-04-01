<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Guest;
use App\Models\Product;
use App\Models\Project;
use App\Models\Corporate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Wishlist>
 */
class WishlistFactory extends Factory
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

        $is_project_wish = false;
        $project_id = null;

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
            $is_project_wish = $this->faker->boolean();
            // Create a Project if there's a project wish, otherwise null
            $project_id = $is_project_wish ? Project::factory()->create()->id : null;
        }
        

        // Return the factory data with related model IDs
        return [
            'guest_id' => $guest_id,
            'user_id' => $user_id,
            'corporate_id' => $corporate_id,
            'is_project_wish' => $is_project_wish,
            'project_id' => $project_id,
            'userType' => $userType,
            'product_id' => Product::factory()->create()->id, // Create Product and assign its ID
        ];
    }
}


            // $table->foreignIdFor(Guest::class)->nullable()->constrained()->onDelete('cascade'); 
            // $table->foreignIdFor(User::class)->nullable()->constrained()->onDelete('cascade'); 
            // $table->foreignIdFor(Corporate::class)->nullable()->constrained()->onDelete('cascade'); 

            // $table->boolean('is_project_wish')->default(false); // Tracks if order is linked to a project
            // $table->foreignIdFor(Project::class)->nullable()->constrained()->onDelete('cascade'); 

            // $table->enum('userType', ['guest', 'customer', 'corporate'])->default('customer');
            // $table->foreignIdFor(Product::class)->constrained()->onDelete('cascade'); 
