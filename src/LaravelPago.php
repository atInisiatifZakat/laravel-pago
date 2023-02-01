<?php

namespace LaravelPago;

use Webmozart\Assert\Assert;
use Psr\Log\LoggerInterface;

final class LaravelPago
{
    private static ?string $pagoRedirectUrl;

    public static function clientFactory(?array $config = null, bool $isSandbox = false, ?LoggerInterface $logger = null): PagoSnapClient
    {
        Assert::nullOrKeyExists($config, 'key');

        return new PagoHttpClient(
            $config ? $config['key'] : '', $isSandbox, $logger
        );
    }

    public static function useRedirectUrl(?string $url = null): void
    {
        self::$pagoRedirectUrl = $url;
    }

    public static function getRedirectUrl(): ?string
    {
        return self::$pagoRedirectUrl;
    }
}
