<?php

namespace LaravelPago\Tests;

use LaravelPago\LaravelPago;
use LaravelPago\PagoSnapClient;

class LaravelPagoTest extends TestCase
{
    public function test_can_create_client(): void
    {
        $client = LaravelPago::clientFactory();

        $this->assertInstanceOf(PagoSnapClient::class, $client);
    }

    public function test_can_change_redirect_url(): void
    {
        LaravelPago::useRedirectUrl('https://pago.example.com');

        $this->assertSame('https://pago.example.com', LaravelPago::getRedirectUrl());
        $this->assertNotSame(config('pago.redirect_url'), LaravelPago::getRedirectUrl());
    }
}
