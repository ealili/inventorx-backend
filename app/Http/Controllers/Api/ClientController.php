<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Models\Client;
use App\Repositories\Client\IClientRepository;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    public function __construct(
        private IClientRepository $clientRepository
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->clientRepository->getAll();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request)
    {
        return $this->clientRepository->create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return $this->clientRepository->get($client);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        return $this->clientRepository->update($request->all(), $client);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        if ($this->clientRepository->delete($client)) {
            return response([''], 204);
        }
        return response(['message' => 'Client could be deleted']);
    }
}
