<?php

namespace Tests\Unit;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_mass_assignable_fields()
    {
        $user = new User();

        $fillable = ['name', 'email', 'password', 'avatar', 'role_id'];

        $this->assertEquals($fillable, $user->getFillable());
    }

    /** @test */
    public function it_hides_sensitive_fields()
    {
        $role = Role::create(['name' => 'admin']);
        $user = User::factory()->create(
            [
                'role_id' => $role->id, // Replace 1 with the actual role ID you want to assign
            ]
        );

        $hidden = ['password', 'remember_token'];

        $this->assertTrue(collect($hidden)->every(function ($item) use ($user) {
            return !array_key_exists($item, $user->toArray());
        }));
    }


    /** @test */
    public function it_has_role_relationship()
    {
        $role = Role::create(['name' => 'admin']);
        $user = User::factory()->create(
            [
                'role_id' => $role->id, // Replace 1 with the actual role ID you want to assign
            ]
        );

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\BelongsTo', $user->role());
    }
}
