<?php

namespace LaravelPago;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelPagoServiceProvider extends PackageServiceProvider
{
    public function registeringPackage(): void
    {
        $this->app->singleton(PagoSnapClient::class, fn() => LaravelPago::clientFactory(
            \config('services.pago'),
            !$this->app->environment('production')
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
