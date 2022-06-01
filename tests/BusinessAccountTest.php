<?php

namespace Tests;

use App\BusinessAccount;
use App\Contracts\Account;
use App\Service\Transaction;
use PHPUnit\Framework\TestCase;

class BusinessAccountTest extends TestCase
{
    protected Account $account;

    public function setUp(): void
    {
        parent::setUp();

        $this->account = new BusinessAccount(1);
    }

    /**
     * @test
     */
    public function it_will_calculate_deposit_charge_at_point_03_percent_for_business_account()
    {
        $transactionMock = $this->createMock(Transaction::class);
        $transactionMock->method('amount')
            ->willReturn(120.00);

        $this->assertEquals(
            0.04,
            $this->account->depositCharge($transactionMock)
        );
    }

    /**
     * @test
     */
    public function it_will_calculate_withdrawal_charge_for_business_account()
    {
        $transactionMock = $this->createMock(Transaction::class);
        $transactionMock->method('amount')
            ->willReturn(120.00);

        $this->assertEquals(
            0.6,
            $this->account->withdrawalCharge($transactionMock)
        );
    }
}