<?php

declare(strict_types=1);

namespace App\Service;

use DateTime;

class Records
{
    private static $instances = [];

    private array $transactions = [];

    private function __construct()
    {
    }

    public static function getInstance(): self
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }

    public function add(Transaction $transaction): float
    {
        $charge = $transaction->commission();
        $this->transactions[$transaction->account()->id()][$transaction->type()][$transaction->date()->format('Y')][$transaction->date()->format('W')][] = [
            'eur_amount' => $transaction->eurAmount(),
            'operation' => $transaction->type(),
            'charge' => $charge,
        ];

        return $charge;
    }

    public function getTransactionsByWeek(int $accountId, string $type, DateTime $date): array
    {
        return $this->transactions[$accountId][$type][$date->format('Y')][$date->format('W')] ?? [];
    }
}
