<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Support\Str;

class TokenServiceProvider
{

    // /**
    //  * Register services.
    //  *
    //  * @return void
    //  */
    // public function register()
    // {
    //     // $this->app->singleton(Connection::class, function ($app) {
    //     //     return new Connection($app['config']['riak']);
    //     // });
    //     // $this->app->bind('HelpSpot\API', function ($app) {
    //     //     return new HelpSpot\API($app->make('HttpClient'));
    //     // });
    // }

    // /**
    //  * Bootstrap services.
    //  *
    //  * @return void
    //  */
    // public function boot()
    // {
    //     //
    // }

    public function deleteToken(User $user_to_update)
    {
        $user_to_update->forceFill([
            'api_token' => null,
        ])->save();

        return null;
    }

    public function updateToken(User $user_to_update)
    {
        $token = Str::random(60);

        $user_to_update->forceFill([
            'api_token' => hash('sha256', $token),
        ])->save();

        return $token;
    }

}
