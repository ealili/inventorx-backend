<?php

namespace App\Repositories\Client;

use App\Http\Resources\ClientResource;
use App\Models\Client;

class ClientRepository implements IClientRepository
{

    public function getAll()
    {
        return ClientResource::collection(
            Client::all()
        );
    }

    public function get(Client $client)
    {
        return new ClientResource($client);
    }

    public function create()
    {
        // TODO: Implement create() method.
    }

    public function update(Client $client)
    {
        // TODO: Implement update() method.
    }

    public function delete(Client $client)
    {
        // TODO: Implement delete() method.
    }
}
