<?php

namespace Luxio\Support\Facades;

use Luxio\Support\Facades\Facade;
use Luxio\Http\Request as LuxioRequest;

class Request extends Facade
{
    public static function getFacadeAccessor()
    {
        return LuxioRequest::class;
    }
}
