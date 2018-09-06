<?php

namespace App\Providers;

use App\Player;
use Laravel\Passport\Passport;
use App\Team;
use App\Policies\TeamPolicy;
use App\Policies\PlayerPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Team::class => TeamPolicy::class,
        Player::class => PlayerPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Gate::define('manage-users', function ($user) {
            return $user->isAdmin();
        });
    }
}
