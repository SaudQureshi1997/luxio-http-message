<?php

namespace Elphis\Support\Facades;

use Elphis\Support\Facades\Facade;
use Elphis\Http\Response as elphisResponse;

class Response extends Facade
{
    public static function getFacadeAccessor()
    {
        return elphisResponse::class;
    }
}
