<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_logs_user_in(): void
    {
        $this->seed();

        DB::table('users')->insert([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => Hash::make('password'),
            'role_id' => Role::ADMIN_ROLE_ID,
            'team_id' => 1,
            'avatar' => 'avatar.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user = User::where('email', 'test@test.com')->first();

        $this->assertNotNull($user);~

        $this->assertDatabaseHas('users', ['email' => 'test@test.com']);

        $authResponse = $this->post('/api/login', [
            'email' => 'test@test.com',
            'password' => 'password',
        ]);

        $authResponse->assertStatus(200);
    }
}
