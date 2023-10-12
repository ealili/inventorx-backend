<?php

namespace App\Repositories\Role;


use App\Http\Resources\RoleResource;
use App\Models\Role;

class RoleRepository implements IRoleRepository
{
    public function get(Role $role)
    {
        return new RoleResource($role);
    }

    public function getAll()
    {
        return RoleResource::collection(
            Role::all()
        );
    }
}
