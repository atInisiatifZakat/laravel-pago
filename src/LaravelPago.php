<?php

namespace LaravelPago;

use Webmozart\Assert\Assert;

final class LaravelPago
{
    private static ?string $pagoRedirectUrl;

    public static function clientFactory(?array $config = null, bool $isSandbox = false): PagoSnapClient
    {
        Assert::nullOrKeyExists($config, 'key');

        return new PagoHttpClient(
            $config ? $config['key'] : '', $isSandbox
        );
    }

    public static function useRedirectUrl(string $url): void
    {
        self::$pagoRedirectUrl = $url;
    }

    public static function getRedirectUrl(): ?string
    {
        return self::$pagoRedirectUrl;
    }
}
