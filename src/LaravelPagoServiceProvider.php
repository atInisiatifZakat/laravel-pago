<?php

namespace LaravelPago;

use Psr\Log\LoggerInterface;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

final class LaravelPagoServiceProvider extends PackageServiceProvider
{
    public function registeringPackage(): void
    {
        $this->app->singleton(PagoSnapClient::class, fn() => LaravelPago::clientFactory(
            \config('services.pago'),
            !$this->app->environment('production'),
            $this->app->make(LoggerInterface::class)
        ));

        $this->app->singleton(PagoSinglePaymentSnapClient::class, fn() => LaravelPago::clientSinglePaymentFactory(
            \config('services.pago'),
            !$this->app->environment('production'),
            $this->app->make(LoggerInterface::class)
        ));
    }

    public function bootingPackage(): void
    {
        LaravelPago::useRedirectUrl(
            \config('services.pago.redirect')
        );
    }

    public function configurePackage(Package $package): void
    {
        $package->name('laravel-pago');
    }
}
