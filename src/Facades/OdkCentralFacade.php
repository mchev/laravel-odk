<?php


namespace Mchev\LaravelOdk\Facades;

use Mchev\LaravelOdk\OdkCentral;
use Illuminate\Support\Facades\Facade;


class OdkCentralFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return OdkCentral::class;
    }
}
