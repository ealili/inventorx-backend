<?php

namespace App\Repositories\User;


use App\Events\User\UserInvited;
use App\Exceptions\Invitations\UserCouldNotBeCreatedException;
use App\Exceptions\Invitations\UserInvitationNotFoundException;
use App\Exceptions\User\UserAlreadyExistsException;
use App\Exceptions\User\UserCouldNotBeInvitedException;
use App\Models\User;
use App\Models\UserInvitation;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserRepository implements IUserRepository
{
    public function getUserById(int $id)
    {
        $user = User::find($id);

        if (!$user) {
            throw UserCouldNotBeCreatedException::withId($id);
        }

        return $user;
    }

    public function paginate()
    {
        return User::where('team_id', Auth::user()->team_id)->orderBy('id', 'desc')->paginate();
    }

    public function create()
    {
        // TODO: Implement create() method.
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    /**
     * @throws UserCouldNotBeInvitedException
     * @throws UserAlreadyExistsException
     */
    public function invite(array $data)
    {
        $user = User::where('email', $data['email'])->first();

        if ($user) {
            throw UserAlreadyExistsException::withEmail($data['email']);
        }

        DB::beginTransaction();
        try {
            $data['invitation_token'] = Str::uuid();

            $userInvitation = UserInvitation::create($data);

            // TODO: Create event to email the invitation to the user
            event(new UserInvited($userInvitation));

            DB::commit();
            return $userInvitation;
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            DB::rollBack();
            throw UserCouldNotBeInvitedException::withEmail($data['email']);
        }
    }

    public function indexInvitedUsers()
    {
        // TODO: Return user invitation collection
        return UserInvitation::all();
    }

    /**
     * @throws UserCouldNotBeCreatedException
     */
    public function createByInvitation(array $data)
    {
        $invitation = UserInvitation::where('invitation_token', $data['invitation_token'])->first();

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $data['name'],
                'password' => bcrypt($data['password']),
                'email' => $invitation->email,
                'role_id' => $invitation->role_id,
                'team_id' => $invitation->team_id
            ]);

            // Delete invitation after successful user creation
            $invitation->delete();

            DB::commit();
            return $user;
        } catch (\Exception $exception) {
            Log::info($exception->getMessage());
            DB::rollBack();
            throw UserCouldNotBeCreatedException::withEmail($invitation['email']);
        }
    }

    public function getAllTeamUserInvitations()
    {
        return UserInvitation::where('team_id', Auth::user()->team_id)->get();
    }

    /**
     * @throws UserInvitationNotFoundException
     */
    public function getInvitationByToken(string $invitationToken)
    {
        $userInvitation = UserInvitation::where('invitation_token', $invitationToken)->first();

        if (!$userInvitation) {
            throw UserInvitationNotFoundException::withToken($invitationToken);
        }

        return $userInvitation;
    }
}
