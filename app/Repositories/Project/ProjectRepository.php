<?php

namespace App\Repositories\Project;

use App\Http\Resources\Project\ProjectResource;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectRepository implements IProjectRepository
{

    public function getAll()
    {
        return Project::where('team_id', Auth::user()->team_id)->get();
    }

    public function get(Project $project)
    {
        return $project;
    }

    public function create(array $data)
    {
        $data['team_id'] = Auth::user()->team_id;
        $project = Project::create($data);

        return $project;
    }

    public function update(array $data, Project $project)
    {
        $project->update($data);

        return $project;
    }

    public function delete(Project $project)
    {
        return $project->delete();
    }
}
