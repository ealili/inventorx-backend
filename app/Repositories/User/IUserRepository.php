<?php

namespace App\Repositories\User;


use App\Models\User;

interface IUserRepository
{
    public function paginate();

    public function get(User $user);

    public function create();

    public function update();
}
