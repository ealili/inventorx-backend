<?php

namespace App\Repositories\Client;

use App\Http\Resources\ClientResource;
use App\Http\Resources\Project\ProjectResource;
use App\Models\Client;
use App\Models\Project;

class ClientRepository implements IClientRepository
{

    public function getAll()
    {
        return ClientResource::collection(
            Client::all()->sortByDesc('created_at')
        );
    }

    public function get(Client $client)
    {
        return new ClientResource($client);
    }

    public function create(array $data)
    {
        $client = Client::create($data);

        return new ClientResource($client);
    }

    public function update(array $data, Client $client)
    {
        $client->update($data);

        return new ClientResource($client);
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
