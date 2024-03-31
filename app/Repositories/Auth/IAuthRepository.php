<?php

namespace App\Repositories\Auth;

interface IAuthRepository {
    public function register(array $userAndTeamData);

    public function login();

    public function logout();
}
