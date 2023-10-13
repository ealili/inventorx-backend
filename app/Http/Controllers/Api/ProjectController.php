<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Project;
use App\Repositories\Project\IProjectRepository;

class ProjectController extends Controller
{
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
        return $this->projectRepository->getAll();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        return $this->projectRepository->create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return $this->projectRepository->get($project);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        return $this->projectRepository->update($request->all(), $project);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if ($this->projectRepository->delete($project)) {
            return response([''], 204);
        }
        return response(['message' => 'Project could be deleted']);
    }
}
