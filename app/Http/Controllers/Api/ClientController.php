<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
    public function store(Request $request)
    {
        return $this->clientRepository->create();
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
    public function update(Request $request, Client $client)
    {
        return $this->clientRepository->update($client);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        return $this->clientRepository->delete($client);
    }
}
