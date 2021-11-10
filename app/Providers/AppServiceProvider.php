<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\User\Entities\User;
use Orchid\Platform\Models\User as OrchidUser;
use Orchid\Support\Facades\Dashboard;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Dashboard::useModel(OrchidUser::class, User::class);
    }
}
