<?php

namespace App\Repositories;


use App\Http\Resources\UserResource;
use App\Models\User;

class UserRepository implements IUserRepository
{
    public function get(User $user)
    {
        return new UserResource($user);
    }

    public function paginate()
    {
        return UserResource::collection(
            User::query()->orderBy('id', 'desc')->paginate()
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
}
