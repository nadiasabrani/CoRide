<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Employe;
use App\Policies\EmployePolicy;
use App\Models\Trajet;
use App\Policies\TrajetPolicy;

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
    Gate::policy(Employe::class, EmployePolicy::class);
    Gate::policy(Trajet::class, TrajetPolicy::class);
}
}
