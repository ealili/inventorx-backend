<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\Project\ProjectCollection;
use App\Http\Resources\Project\ProjectResource;
use App\Models\Project;
use App\Repositories\Project\IProjectRepository;
use App\Traits\ResponseApi;

class ProjectController extends Controller
{
    use ResponseApi;

    public function __construct(
        private IProjectRepository $projectRepository
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->respondWithCollection(ProjectCollection::class,
            $this->projectRepository->getAll());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        return $this->respondWithItem(ProjectResource::class,
            $this->projectRepository->create($request->all()
            ));
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return $this->respondWithItem(ProjectResource::class, $project);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        return $this->respondWithItem(ProjectResource::class,
            $this->projectRepository->update($request->all(), $project));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if ($this->projectRepository->delete($project)) {
            return $this->respondWithCustomData(['message' => 'Client deleted'], 204);
        }
        return $this->respondWithCustomData(['message' => 'Project could not be deleted'], 422);
    }
}
