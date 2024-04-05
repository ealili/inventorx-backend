<?php

namespace App\Repositories\Task;

use App\Http\Resources\Task\TaskResource;
use App\Models\Task;

class TaskRepository implements ITaskRepository
{
    public function getAll()
    {
        return Task::all();
    }

    public function get(Task $task)
    {
        return $task;
    }

    public function create(array $data)
    {
        $task = Task::create($data);

        return $task;
    }

    public function update(array $data, Task $task)
    {
        $task->update($data);

        return $task;
    }

    public function delete(Task $task)
    {
        return $task->delete();
    }

    public function assignToTask(Task $task, int $assigneeId)
    {
        try {
            $task->update(['assignee_id' => $assigneeId]);
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }
}
