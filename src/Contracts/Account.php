<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Service\Transaction;

interface Account
{
    /**
     * Calculate the deposit charge for a transaction.
     */
    public function depositCharge(Transaction $transaction): float;

    /**
     * Calculate the withdrawal charge for a transaction.
     */
    public function withdrawalCharge(Transaction $transaction): float;
}
