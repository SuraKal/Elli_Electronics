<?php

namespace Database\Seeders;

use App\Models\Corporate;
use App\Models\Project;
use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $admin = User::factory(1)
            ->afterCreating(fn(User $user) => $user->roles()->attach($adminRole->id))
            ->create([
                'name' => 'Elli Electrical Equipement',
                'email' => 'admin@mail.com',
                'password' => 'admin@mail.com',
                'status' => 'active'
            ]);

        
        // User::factory(10)->create();

        // User::factory(10)->create()->each(function ($user) {
        //     // Create a corporate for each user
        //     $corporate = Corporate::factory()->create([
        //         'user_id' => $user->id,
        //     ]);

        //     // Create multiple projects for each corporate
        //     Project::factory(rand(2, 5))->create([
        //         'corporate_id' => $corporate->id,
        //     ]);
        // });

        // $this->call(ProjectSeeder::class);
        // $this->call(OrderSeeder::class);
        $this->call(SystemSeeder::class);
    }
}
