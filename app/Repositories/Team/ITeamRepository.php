<?php

namespace App\Repositories\Team;

use App\Models\Team;

interface ITeamRepository
{
    public function get(Team $team);

    public function create(array $data);

    public function update(array $data, Team $team);

    public function delete(Team $team);
}
