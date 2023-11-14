<?php

namespace App\Repositories\User;


use App\Events\User\UserInvited;
use App\Exceptions\User\UserAlreadyExistsException;
use App\Exceptions\User\UserCouldNotBeInvitedException;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\UserInvitation;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserRepository implements IUserRepository
{
    public function get(User $user)
    {
        return new UserResource($user);
    }

    public function paginate()
    {
        return UserResource::collection(
            User::query()->where('team_id', Auth::user()->team_id)->orderBy('id', 'desc')->paginate()
        );
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
}
