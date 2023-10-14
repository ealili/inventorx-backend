<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Models\Task;
use App\Repositories\Task\ITaskRepository;
use Illuminate\Http\Request;

class TaskController extends Controller
{
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
        return $this->taskRepository->getAll();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        return $this->taskRepository->create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return $this->taskRepository->get($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        return $this->taskRepository->update($request->all(), $task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if ($this->taskRepository->delete($task)) {
            return response([''], 204);
        }
        return response(['message' => 'Task could be deleted']);
    }
}
