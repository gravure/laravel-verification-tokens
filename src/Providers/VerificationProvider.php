<?php

namespace Gravure\Verification\Providers;

use Gravure\Verification\Controllers\CallbackController;
use Illuminate\Support\ServiceProvider;

class VerificationProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadMigrationsFrom([
            __DIR__ .'/../../migrations/'
        ]);
        
        $this->app['router']->get('/verification/{token}', [
            'as' => 'verification.callback',
            'uses' => CallbackController::class . '@handle'
        ]);
    }
}
