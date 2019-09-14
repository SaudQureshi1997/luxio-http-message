<?php

namespace Elphis\Providers;

use Elphis\Http\Request;
use Elphis\Http\Response;
use Elphis\Providers\ServiceProvider;
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
