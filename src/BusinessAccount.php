<?php

declare(strict_types=1);

namespace App;

use App\Service\Math;
use App\Service\Transaction;

class BusinessAccount extends Account implements \App\Contracts\Account
{
    public const WITHDRAW_CHARGE_PERCENTAGE = 0.5;

    /**
     * Calculate the withdrawal charge for a transaction.
     */
    public function withdrawalCharge(Transaction $transaction): float
    {
        return Math::ceil(($transaction->amount() * self::WITHDRAW_CHARGE_PERCENTAGE) / 100, 2);
    }
}
