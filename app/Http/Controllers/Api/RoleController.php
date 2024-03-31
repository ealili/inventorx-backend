<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Role\RoleCollection;
use App\Http\Resources\Role\RoleResource;
use App\Models\Role;
use App\Repositories\Role\IRoleRepository;
use App\Traits\ResponseApi;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    use ResponseApi;

    public function __construct(
        private IRoleRepository $roleRepository
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->respondWithCollection(
            RoleCollection::class,
            $this->roleRepository->getAll()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return $this->respondWithItem(
            RoleResource::class,
            $this->roleRepository-> get($role)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
