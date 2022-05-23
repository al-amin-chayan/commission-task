<?php

declare(strict_types=1);

namespace App\Service;

class CurrencyExchange
{
    private const URL = 'https://developers.paysera.com/tasks/api/currency-exchange-rates';

    private static array $rates = [];

    /**
     * Get the exchange rate based on EURO value.
     */
    public static function rate(string $currency): ?float
    {
        if (count(self::$rates) === 0) {
            $contents = file_get_contents(self::URL);
            $data = json_decode($contents, true);
            self::$rates = $data['rates'];
        }

        return self::$rates[$currency] ?? null;
    }
}
