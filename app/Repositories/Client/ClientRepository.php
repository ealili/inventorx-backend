<?php

namespace App\Repositories\Client;

use App\Http\Resources\Client\ClientResource;
use App\Http\Resources\Project\ProjectResource;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ClientRepository implements IClientRepository
{

    public function getAll()
    {
        return  Client::where('team_id', Auth::user()->team_id)->get()->sortByDesc('created_at');
    }

    public function get(Client $client)
    {
        return $client;
    }

    public function create(array $data)
    {
        $data['team_id'] = Auth::user()->team_id;
        return Client::create($data);
    }

    public function update(array $data, Client $client)
    {
        $client->update($data);

        return $client;
    }

    public function delete(Client $client)
    {
        return $client->delete();
    }

    public function getProjectsByClientId(int $clientId)
    {
        $projects = Project::where('client_id', $clientId)->get();

        return ProjectResource::collection($projects);
    }
}
