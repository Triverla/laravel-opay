<?php

namespace Triverla\LaravelOpay\Facades;

use Illuminate\Support\Facades\Facade;

class Opay extends Facade
{

    protected static function getFacadeAccessor(): string
    {
        return 'laravel-opay';
    }
}
