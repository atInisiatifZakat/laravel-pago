<?php

namespace LaravelPago\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use LaravelPago\LaravelPagoServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            LaravelPagoServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');
        config()->set('pago.redirect_url', 'https://example.com');
    }
}
