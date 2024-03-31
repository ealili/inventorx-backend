<?php

namespace App\Repositories\Role;

use App\Models\Role;

class RoleRepository implements IRoleRepository
{
    public function get(Role $role)
    {
        return $role;
    }

    public function getAll()
    {
        return Role::all();
    }
}
