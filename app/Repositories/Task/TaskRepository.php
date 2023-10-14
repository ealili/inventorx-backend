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

    public function get(Task $task)
    {
        return new TaskResource($task);
    }

    public function create(array $data)
    {
        $task = Task::create($data);

        return new TaskResource($task);
    }

    public function update(array $data, Task $task)
    {
        $task->update($data);
        return new TaskResource($task);

    }

    public function delete(Task $task)
    {
        return $task->delete();
    }
}
