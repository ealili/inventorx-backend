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
}
