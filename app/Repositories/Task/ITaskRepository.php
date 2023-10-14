<?php

namespace App\Repositories\Task;

use App\Models\Task;

interface ITaskRepository
{
    public function getAll();

    public function get(Task $project);

    public function create(array $data);

    public function update(array $data, Task $project);

    public function delete(Task $project);
}
