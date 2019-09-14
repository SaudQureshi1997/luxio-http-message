<?php

namespace Elphis\Support\Facades;

use Elphis\Support\Facades\Facade;
use Elphis\Http\Request as elphisRequest;

class Request extends Facade
{
    public static function getFacadeAccessor()
    {
        return elphisRequest::class;
    }
}
