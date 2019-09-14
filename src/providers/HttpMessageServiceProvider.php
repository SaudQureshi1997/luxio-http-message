<?php

namespace elphis\Providers;

use elphis\Http\Request;
use elphis\Http\Response;
use elphis\Providers\ServiceProvider;
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
