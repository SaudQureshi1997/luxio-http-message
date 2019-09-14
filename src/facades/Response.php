<?php

namespace elphis\Support\Facades;

use elphis\Support\Facades\Facade;
use elphis\Http\Response as elphisResponse;

class Response extends Facade
{
    public static function getFacadeAccessor()
    {
        return elphisResponse::class;
    }
}
