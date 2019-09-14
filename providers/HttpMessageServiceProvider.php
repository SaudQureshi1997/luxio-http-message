<?php

namespace Luxio\Http\Providers;

use Luxio\Http\Request;
use Luxio\Http\Response;
use Luxio\Providers\ServiceProvider;
use Swoole\Http\Request as SwooleRequest;

class HttpMessageServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(Request::class, function ($app) {
            $request = $app->resolve(SwooleRequest::class);
            return new Request(
                $_SERVER,
                $_GET,
                $_POST,
                $_COOKIE,
                $request->rawContent()
            );
        });

        $this->app->bind(Response::class, function ($app) {
            $request = $app->resolve(SwooleRequest::class);
            return new Response($request->fd);
        });
    }
}
