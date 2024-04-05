<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\AssignEmployeeToTaskRequest;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\Task\TaskCollection;
use App\Http\Resources\Task\TaskResource;
use App\Models\Task;
use App\Repositories\Task\ITaskRepository;
use App\Traits\ResponseApi;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    use ResponseApi;

    public function __construct(
        private readonly ITaskRepository $taskRepository
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->respondWithCollection(TaskCollection::class,
            $this->taskRepository->getAll());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        return $this->respondWithItem(TaskResource::class,
            $this->taskRepository->create($request->all()
            ));
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return $this->respondWithItem(TaskResource::class,
            $this->taskRepository->get($task));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        return $this->respondWithItem(TaskResource::class,
            $this->taskRepository->update($request->all(), $task));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if ($this->taskRepository->delete($task)) {
            return $this->respondWithCustomData(['message' => 'Task deleted.'], 204);
        }
        return $this->respondWithCustomData(['message' => 'Task could not be deleted.'], 422);
    }

    /**
     * Assign user/employee the specified task in storage.
     */
    public function assignToTask(AssignEmployeeToTaskRequest $request, Task $task)
    {
        if ($this->taskRepository->assignToTask($task, $request->assignee_id)) {
            return $this->respondWithCustomData(['message' => 'Employee has been assigned to task.']);
        }
        return $this->respondWithCustomData(['message' => 'Could not assign employee to task.']);
    }
}
