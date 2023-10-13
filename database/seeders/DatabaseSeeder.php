<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            ProjectStatusSeeder::class,
        ]);

        \App\Models\User::factory(40)->create();
        \App\Models\Client::factory(20)->create();
        \App\Models\Project::factory(20)->create();

        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@mail.com',
            'password' => bcrypt('password'),
            'avatar' => env('APP_URL') . '/storage/avatars/' . 'default-profile-picture.jpeg',
            'role_id' => 1
        ]);
    }
}
