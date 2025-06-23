<?php

namespace App\Providers;

use App\Models\Application;
use App\Models\ApplicationStatus;
use App\Models\Fsic;
use App\Models\Schedule;
use App\Models\User;
use App\Observers\ApplicationObserver;
use App\Observers\ApplicationStatusObserver;
use App\Observers\FsicObserver;
use App\Observers\ScheduleObserver;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Application::observe(ApplicationObserver::class);
        ApplicationStatus::observe(ApplicationStatusObserver::class);
        Schedule::observe(ScheduleObserver::class);
        Fsic::observe(FsicObserver::class);
    }
}
