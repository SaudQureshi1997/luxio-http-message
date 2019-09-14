<?php

namespace elphis\Support\Facades;

use elphis\Support\Facades\Facade;
use elphis\Http\Request as elphisRequest;

class Request extends Facade
{
    public static function getFacadeAccessor()
    {
        return elphisRequest::class;
    }
}
