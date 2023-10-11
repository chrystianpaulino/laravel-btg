<?php

namespace BeeDelivery\Btg\Facades;

use Illuminate\Support\Facades\Facade;

class Btg extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'btg';
    }
}
