<?php

namespace Mchev\LaravelOdk\Tests;

use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;
use Orchestra\Testbench\TestCase as Orchestra;
use Config;

abstract class TestCase extends Orchestra
{
    protected function getEnvironmentSetUp($app): void
    {
        // Load the .env file
        $app->useEnvironmentPath(__DIR__.'/..');
        $app->bootstrapWith([LoadEnvironmentVariables::class]);
        parent::getEnvironmentSetUp($app);

        Config::set('odkcentral.api_url', 'https://private-anon-f36a3f79fb-odkcentral.apiary-mock.com/v1');
        Config::set('odkcentral.user_email', 'my.email.address@getodk.org');
        Config::set('odkcentral.user_password', 'my.super.secure.password');

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