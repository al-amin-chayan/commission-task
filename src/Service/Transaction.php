<?php

declare(strict_types=1);

namespace App\Service;

use App\Contracts\Account;
use DateTime;

class Transaction
{
    public const WITHDRAW = 'withdraw';
    public const DEPOSIT = 'deposit';

    private Account $account;
    protected DateTime $date;
    protected string $type;
    protected float $amount;
    protected string $currency;

    public function __construct(Account $account, string $date, string $type, float $amount, string $currency)
    {
        $this->account = $account;
        $this->date = new DateTime($date);
        $this->type = $type;
        $this->amount = $amount;
        $this->currency = $currency;
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
