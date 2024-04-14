<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            TaskStatusSeeder::class,
        ]);

        \App\Models\Team::factory(15)->create();
        \App\Models\User::factory(40)->create();
        \App\Models\Client::factory(20)->create();
        \App\Models\Project::factory(20)->create();
        \App\Models\Task::factory(20)->create();

        DB::table('users')->insert([
            'name' => 'Admin User',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password'),
            'avatar' => env('APP_URL') . '/storage/avatars/' . 'default-profile-picture.jpeg',
            'role_id' => 1,
            'team_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        \App\Models\User::create([
            'name' => 'User',
            'email' => 'user@mail.com',
            'password' => bcrypt('password'),
            'avatar' => env('APP_URL') . '/storage/avatars/' . 'default-profile-picture.jpeg',
            'role_id' => 2,
            'team_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
