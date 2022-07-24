<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;

class LINEBotServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CurlHTTPClient::class, function () {
            return new CurlHTTPClient(config('line-bot.channel_access_token'));
        });
        $this->app->bind(LINEBot::class, function ($app) {
            $httpClient = $app->make(CurlHTTPClient::class);
            return new LINEBot($httpClient, ['channelSecret' => config('line-bot.channel_secret')]);
        });
    }
}
