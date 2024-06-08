<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\SubmissionRepoInterface;
use App\Repositories\SubmissionRepo;

class RepoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(SubmissionRepoInterface::class, SubmissionRepo::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
