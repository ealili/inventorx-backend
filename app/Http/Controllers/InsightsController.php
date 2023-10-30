<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class InsightsController extends Controller
{
    /**
     * Provision a new web server.
     */
    public function __invoke()
    {
        // TODO: Base models count on team
        $usersCount = User::all()->count();
        $clientsCounts = Client::all()->count();
        $projectsCount = Project::all()->count();
        $tasksCount = Task::all()->count();

        return response(
            [
                'users_count' => $usersCount,
                'clients_count' => $clientsCounts,
                'projects_count' => $projectsCount,
                'tasks_count' => $tasksCount
            ],
            200
        );
    }
}
