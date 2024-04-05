<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Http\Resources\Client\ClientCollection;
use App\Http\Resources\Client\ClientResource;
use App\Models\Client;
use App\Repositories\Client\IClientRepository;
use App\Traits\ResponseApi;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    use ResponseApi;

    public function __construct(
        private IClientRepository $clientRepository
    )
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return ClientCollection
     */
    public function index()
    {
        return $this->respondWithCollection(ClientCollection::class,
            $this->clientRepository->getAll());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreClientRequest $request
     * @return ClientResource
     */
    public function store(StoreClientRequest $request)
    {
        return $this->respondWithItem(ClientResource::class,
            $this->clientRepository->create($request->all()
            ));
    }

    /**
     * Display the specified resource.
     *
     * @param Client $client
     * @return ClientResource
     */
    public function show(Client $client)
    {
        return $this->respondWithItem(ClientResource::class, $client);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateClientRequest $request
     * @param Client $client
     * @return ClientResource
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        return $this->respondWithItem(ClientResource::class,
            $this->clientRepository->update($request->all(), $client));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Client $client
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Client $client)
    {
        if ($this->clientRepository->delete($client)) {
            return $this->respondWithCustomData(['message' => 'Client deleted'], 204);
        }
        // TODO: THrow exception
        return $this->respondWithCustomData(['message' => 'Client could not be deleted'], 422);
    }

    /**
     * Display a listing of projects of the resource.
     *
     * @param Request $request
     * @param Client $client
     * @return mixed
     */
    public function indexProjectsByClientId(Request $request, Client $client)
    {
        // TODO: Respond with collection
        return $this->clientRepository->getProjectsByClientId($client->id);
    }
}
