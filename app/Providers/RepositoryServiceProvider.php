<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

# User
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;

# Project
use App\Repositories\Project\ProjectRepository;
use App\Repositories\Project\ProjectRepositoryInterface;

# Project Image
use App\Repositories\ProjectImage\ProjectImageRepository;
use App\Repositories\ProjectImage\ProjectImageRepositoryInterface;

# Support
use App\Repositories\Support\SupportRepository;
use App\Repositories\Support\SupportRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);
        $this->app->bind(ProjectImageRepositoryInterface::class, ProjectImageRepository::class);
        $this->app->bind(SupportRepositoryInterface::class, SupportRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
