<?php

namespace Mchev\LaravelOdk\Facades;

use Illuminate\Support\Facades\Facade;
use Mchev\LaravelOdk\OdkCentral;

class OdkCentralFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return new OdkCentral;
    }
}
