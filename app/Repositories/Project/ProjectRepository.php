<?php

namespace App\Repositories\Project;

use App\Http\Resources\Project\ProjectResource;
use App\Models\Project;

class ProjectRepository implements IProjectRepository
{

    public function getAll()
    {
        return ProjectResource::collection(
            Project::all()
        );
    }

    public function get(Project $project)
    {
        // TODO: Implement get() method.
    }

    public function create(array $data)
    {
        // TODO: Implement create() method.
    }

    public function update(array $data, Project $project)
    {
        // TODO: Implement update() method.
    }

    public function delete(Project $project)
    {
        // TODO: Implement delete() method.
    }
}
