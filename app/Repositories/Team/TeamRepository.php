<?php

namespace App\Repositories\Team;

use App\Http\Resources\Team\TeamResource;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;

class TeamRepository implements ITeamRepository
{
    public function create(array $data)
    {
        $data['owner_id'] = Auth::id();
        $team = Team::create($data);

        return new TeamResource($team);
    }

    public function get(Team $team)
    {
        return new TeamResource($team);
    }

    public function update(array $data, Team $team)
    {
        $team->update($data);

        return new TeamResource($team);
    }

    public function delete(Team $team)
    {
        return $team->delete();
    }
}
