<?php

namespace App\Providers;

use App\Repositories\Contracts\LoanRepository;
use App\Repositories\Contracts\PaymentRepository;
use App\Repositories\Contracts\UserRepository;
use App\Repositories\LoanRepositoryImpl;
use App\Repositories\PaymentRepositoryImpl;
use App\Repositories\UserRepositoryImpl;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepository::class, UserRepositoryImpl::class);
        $this->app->bind(LoanRepository::class, LoanRepositoryImpl::class);
        $this->app->bind(PaymentRepository::class, PaymentRepositoryImpl::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
    }
}
