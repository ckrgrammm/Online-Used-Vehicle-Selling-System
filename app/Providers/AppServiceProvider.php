<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Observers\UserFormSubmissionObserver;

use App\Models\User;
use App\Models\Admin;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        User::observe(UserFormSubmissionObserver::class);
        //Admin::observe(AdminFormSubmissionObserver::class);
    }
    
}
