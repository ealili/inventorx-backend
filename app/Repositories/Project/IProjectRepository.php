<?php

namespace App\Repositories\Project;

use App\Models\Project;

interface IProjectRepository
{
    public function getAll();

    public function get(Project $project);

    public function create(array $data);

    public function update(array $data, Project $project);

    public function delete(Project $project);
}
