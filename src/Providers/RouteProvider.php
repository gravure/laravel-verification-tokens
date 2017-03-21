<?php

namespace Gravure\Verification\Providers;

use Gravure\Verification\Controllers\CallbackController;
use Illuminate\Support\ServiceProvider;

class RouteProvider extends ServiceProvider
{
    public function register()
    {
        $this->app['router']->get('/verification/{token}', [
            'as' => 'verification.callback',
            'uses' => CallbackController::class . '@handle'
        ]);
    }
}
