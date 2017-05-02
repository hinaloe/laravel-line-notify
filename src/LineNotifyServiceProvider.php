<?php

namespace Hinaloe\LineNotify;

use Hinaloe\LineNotify\Channel\LineChannel;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\ServiceProvider;

class LineNotifyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->make(ChannelManager::class)->extend('line', function ($app) {
            return $app->make(LineChannel::class);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
