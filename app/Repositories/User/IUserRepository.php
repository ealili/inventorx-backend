<?php

namespace App\Repositories\User;


use App\Models\User;

interface IUserRepository
{
    public function paginate();

    public function get(User $user);

    public function create();

    public function createByInvitation(array $data);

    public function update();

    public function invite(array $data);

    public function indexInvitedUsers();

    public function getAllTeamUserInvitations();

    public function getInvitationByToken(string $invitationToken);
}
