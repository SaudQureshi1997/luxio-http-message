<?php

namespace Luxio\Http\Providers;

use Luxio\Http\Request;
use Luxio\Providers\ServiceProvider;
use Swoole\Http\Request as SwooleRequest;

class RequestServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(Request::class, function ($app) {
            $request = $app->resolve(SwooleRequest::class);
            return new Request(
                $request->rawContent()
            );
        });
    }
}
