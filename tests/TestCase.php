<?php

namespace Mchev\LaravelOdk\Tests;

use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getEnvironmentSetUp($app): void
    {
        // Load the .env file
        $app->useEnvironmentPath(__DIR__.'/..');
        $app->bootstrapWith([LoadEnvironmentVariables::class]);
        parent::getEnvironmentSetUp($app);

    }

    protected function getPackageProviders($app): array
    {
        return [
            'Mchev\LaravelOdk\Providers\OdkCentralServiceProvider',
        ];
    }

    protected function getPackageAliases($app): array
    {
        return [
            'OdkCentral' => 'Mchev\LaravelOdk\Facades\OdkCentralFacade',
        ];
    }
}