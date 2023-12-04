<?php

namespace Tests\Unit;

use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_mass_assignable_fields()
    {
        $user = new User();

        $fillable = ['name', 'email', 'password', 'avatar', 'role_id', 'team_id'];

        $this->assertEquals($fillable, $user->getFillable());
    }

    /** @test */
    public function it_hides_sensitive_fields()
    {
        $role = Role::create(['name' => 'admin']);
        $team = Team::create(['name' => 'MyTeam']);
        $user = User::factory()->create(
            [
                'role_id' => $role->id,
                'team_id' => $team->id,
                'password' => Hash::make('password')
            ]
        );

        $hidden = ['password', 'remember_token'];

        $this->assertTrue(collect($hidden)->every(function ($item) use ($user) {
            return !array_key_exists($item, $user->toArray());
        }));
    }


    /** @test */
    public function it_has_role_and_team_relationships()
    {
        $role = Role::create(['name' => 'Test Role']);
        $team = Team::create(['name' => 'MyTeam']);

        $user = User::factory()->create(['role_id' => $role->id, 'team_id' => $team->id,
            'password' => Hash::make('password')]);

        $this->assertInstanceOf(Role::class, $user->role);
        $this->assertInstanceOf(Team::class, $user->team);
    }
}
