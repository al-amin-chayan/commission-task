<?php

declare(strict_types=1);

namespace App\Service;

use App\Contracts\Account;
use DateTime;

class Transaction
{
    public const WITHDRAW = 'withdraw';
    public const DEPOSIT = 'deposit';

    protected DateTime $date;

    public function __construct(
        protected Account $account,
        protected string $type,
        protected float $amount,
        protected string $currency,
        string $date
    ) {
        $this->date = new DateTime($date);
    }

    public function date()
    {
        return $this->date;
    }

    public function account(): Account
    {
        return $this->account;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function currency(): string
    {
        return $this->currency;
    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function eurAmount(): float
    {
        return $this->amount * CurrencyExchange::rate($this->currency);
    }

    public function commission(): float
    {
        if ($this->isDeposit()) {
            return $this->account()->depositCharge($this);
        }

        return $this->account()->withdrawalCharge($this);
    }

    public function isDeposit(): bool
    {
        return $this->type() === self::DEPOSIT;
    }

    public function isWithdraw(): bool
    {
        return $this->type() === self::WITHDRAW;
    }
}
