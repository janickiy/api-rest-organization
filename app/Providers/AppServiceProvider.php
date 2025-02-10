<?php

namespace App\Providers;

use App\Contracts\ActivityRepositoryInterface;
use App\Contracts\BuildingRepositoryInterface;
use App\Contracts\OrganizationRepositoryInterface;
use App\Repositories\ActivityRepository;
use App\Repositories\BuildingRepository;
use App\Repositories\OrganizationRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(OrganizationRepositoryInterface::class, OrganizationRepository::class);
        $this->app->bind(BuildingRepositoryInterface::class, BuildingRepository::class);
        $this->app->bind(ActivityRepositoryInterface::class, ActivityRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
