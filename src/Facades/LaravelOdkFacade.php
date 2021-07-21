<?php


namespace Mchev\LaravelOdk\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mchev\LaravelOdk\Skeleton\SkeletonClass
 */


class LaravelOdkFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-odk';
    }
}
