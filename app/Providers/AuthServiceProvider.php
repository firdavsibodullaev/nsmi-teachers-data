<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        Auth::provider('CustomUserProvider', function ($app, array $config) {
            return new CustomAuthServiceProvider($app['hash'], $config['model']);
        });
        $this->registerPolicies();
        Passport::routes();
        Passport::personalAccessTokensExpireIn(now()->addDay());
        Passport::personalAccessClientId(
            config('passport.personal_access_client.id')
        );

        Passport::personalAccessClientSecret(
            config('passport.personal_access_client.secret')
        );
        //
    }
}
