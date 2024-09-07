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

# Tag
use App\Repositories\Tag\TagRepository;
use App\Repositories\Tag\TagRepositoryInterface;

# History
use App\Repositories\History\HistoryRepository;
use App\Repositories\History\HistoryRepositoryInterface;

# Notification
use App\Repositories\Notification\NotificationRepository;
use App\Repositories\Notification\NotificationRepositoryInterface;

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
        $this->app->bind(TagRepositoryInterface::class, TagRepository::class);
        $this->app->bind(NotificationRepositoryInterface::class, NotificationRepository::class);
        $this->app->bind(HistoryRepositoryInterface::class, HistoryRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
