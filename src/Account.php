<?php

declare(strict_types=1);

namespace App;

use App\Service\Math;
use App\Service\Transaction;

abstract class Account
{
    public const DEPOSIT_CHARGE_PERCENTAGE = 0.03;

    public function __construct(protected int $id)
    {

    }

    public function id()
    {
        return $this->id;
    }

    /**
     * Calculate the deposit charge for a transaction.
     */
    public function depositCharge(Transaction $transaction): float
    {
        return Math::ceil(($transaction->amount() * self::DEPOSIT_CHARGE_PERCENTAGE) / 100, 2);
    }

    abstract public function withdrawalCharge(Transaction $transaction): float;
}
