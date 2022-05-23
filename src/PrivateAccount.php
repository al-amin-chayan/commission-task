<?php

declare(strict_types=1);

namespace App;

use App\Service\CurrencyExchange;
use App\Service\Math;
use App\Service\Records;
use App\Service\Transaction;

class PrivateAccount extends Account implements \App\Contracts\Account
{
    public const WITHDRAW_CHARGE_PERCENTAGE = 0.3;
    public const WEEKLY_MAX_FREE_TRANSACTION_COUNT = 3;
    public const WEEKLY_MAX_FREE_TRANSACTION_AMOUNT = 1000;

    /**
     * Calculate the withdrawal charge for a transaction.
     */
    public function withdrawalCharge(Transaction $transaction): float
    {
        $amount = $this->getChargeableAmount($transaction);

        return Math::ceil(($amount * self::WITHDRAW_CHARGE_PERCENTAGE) / 100, 2);
    }

    private function getChargeableAmount(Transaction $transaction): float
    {
        $records = Records::getInstance();

        $previousTransactions = $records->getTransactionsByWeek(
            $transaction->account()->id(),
            $transaction->type(),
            $transaction->date()
        );

        if (count($previousTransactions) >= self::WEEKLY_MAX_FREE_TRANSACTION_COUNT) {
            return $transaction->amount();
        }

        $transactionAmount = array_sum(array_column($previousTransactions, 'eur_amount'));

        if ($transactionAmount >= self::WEEKLY_MAX_FREE_TRANSACTION_AMOUNT) {
            return $transaction->amount();
        }

        $tobeTransactionAmount = $transactionAmount + $transaction->eurAmount();
        if ($tobeTransactionAmount >= self::WEEKLY_MAX_FREE_TRANSACTION_AMOUNT) {
            $chargeableAmountInEuro = $tobeTransactionAmount - self::WEEKLY_MAX_FREE_TRANSACTION_AMOUNT;

            return $chargeableAmountInEuro / CurrencyExchange::rate($transaction->currency());
        }

        return 0;
    }
}
