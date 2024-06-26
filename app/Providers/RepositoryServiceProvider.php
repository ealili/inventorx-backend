<?php

namespace App\Providers;

use App\Repositories\Auth\AuthRepository;
use App\Repositories\Auth\IAuthRepository;
use App\Repositories\Client\ClientRepository;
use App\Repositories\Client\IClientRepository;
use App\Repositories\Project\IProjectRepository;
use App\Repositories\Project\ProjectRepository;
use App\Repositories\Role\IRoleRepository;
use App\Repositories\Role\RoleRepository;
use App\Repositories\Task\ITaskRepository;
use App\Repositories\Task\TaskRepository;
use App\Repositories\Team\ITeamRepository;
use App\Repositories\Team\TeamRepository;
use App\Repositories\User\IUserRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IRoleRepository::class, RoleRepository::class);
        $this->app->bind(IClientRepository::class, ClientRepository::class);
        $this->app->bind(IProjectRepository::class, ProjectRepository::class);
        $this->app->bind(ITaskRepository::class, TaskRepository::class);
        $this->app->bind(ITeamRepository::class, TeamRepository::class);
        $this->app->bind(IAuthRepository::class, AuthRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
