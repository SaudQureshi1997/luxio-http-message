<?php

namespace Luxio\Support\Facades;

use Luxio\Support\Facades\Facade;
use Luxio\Http\Response as LuxioResponse;

class Response extends Facade
{
    public static function getFacadeAccessor()
    {
        return LuxioResponse::class;
    }
}
