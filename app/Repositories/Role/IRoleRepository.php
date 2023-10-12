<?php

namespace App\Repositories\Role;


use App\Models\Role;

interface IRoleRepository
{
    public function getAll();

    public function get(Role $role);

}
