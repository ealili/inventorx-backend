<?php

namespace App\Repositories\Task;

use App\Http\Resources\TaskResource;
use App\Models\Task;

class TaskRepository implements ITaskRepository
{

    public function getAll()
    {
        return TaskResource::collection(Task::all());
    }

    public function get(Task $project)
    {
        // TODO: Implement get() method.
    }

    public function create(array $data)
    {
        // TODO: Implement create() method.
    }

    public function update(array $data, Task $project)
    {
        // TODO: Implement update() method.
    }

    public function delete(Task $project)
    {
        // TODO: Implement delete() method.
    }
}
