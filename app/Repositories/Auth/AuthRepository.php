<?php

namespace App\Repositories\Auth;

use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthRepository implements IAuthRepository
{
    public function register(array $userAndTeamData)
    {
        DB::beginTransaction();

        try {
            $team = Team::create(['name' => $userAndTeamData['team_name']]);

            $avatarPath = env('APP_URL') . '/storage/avatars/' . 'default-profile-picture.jpeg';

            /** @var User $user */
            User::create([
                'name' => $userAndTeamData['name'],
                'email' => $userAndTeamData['email'],
                'password' => $userAndTeamData['password'],
                'avatar' => $avatarPath,
                'role_id' => Role::ADMIN_ROLE_ID,
                'team_id' => $team->id
            ]);

            DB::commit();
        } catch (\Exception $exception) {
            Log::info("Error creating team $userAndTeamData->team_name and user $userAndTeamData->name");
            Log::error($exception->getMessage());
            DB::rollBack();
        }
    }

    public function login()
    {
        // TODO: Implement login() method.
    }

    public function logout()
    {
        // TODO: Implement logout() method.
    }
}
