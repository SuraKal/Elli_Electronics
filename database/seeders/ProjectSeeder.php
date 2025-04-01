<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use App\Models\Corporate;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create 10 users
        User::factory(3)->create()->each(function ($user) {
            // Create a corporate for each user
            $corporate = Corporate::factory()->create([
                'user_id' => $user->id,
            ]);

            // Create multiple projects for each corporate
            Project::factory(rand(2, 5))->create([
                'corporate_id' => $corporate->id,
            ]);
        });
    }
}
