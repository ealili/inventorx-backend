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
        return new ProjectResource($project);
    }

    public function create(array $data)
    {
        $project = Project::create($data);

        return new ProjectResource($project);
    }

    public function update(array $data, Project $project)
    {
        $project->update($data);

        return new ProjectResource($project);
    }

    public function delete(Project $project)
    {
        return $project->delete();
    }
}
