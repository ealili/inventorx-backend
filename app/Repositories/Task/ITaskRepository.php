<?php

namespace App\Repositories\Task;

use App\Models\Task;

interface ITaskRepository
{
    public function getAll();

    public function get(Task $task);

    public function create(array $data);

    public function update(array $data, Task $task);

    public function delete(Task $task);
}
