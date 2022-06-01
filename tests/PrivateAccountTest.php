<?php

namespace Tests;

use App\Contracts\Account;
use App\PrivateAccount;
use App\Service\Transaction;
use PHPUnit\Framework\TestCase;

class PrivateAccountTest extends TestCase
{
    protected Account $account;

    public function setUp(): void
    {
        parent::setUp();

        $this->account = new PrivateAccount(1);
    }

    /**
     * @test
     */
    /**
     * @test
     */
    public function it_will_calculate_deposit_charge_at_point_03_percent_for_private_account()
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
    public function it_will_calculate_withdrawal_charge_as_free_for_first_3_transaction_a_week_upto_1000()
    {
        $transcation1 = new Transaction($this->account, 'withdraw', 100, 'EUR', '2022-05-29');

        $this->assertEquals(
            0,
            $this->account->withdrawalCharge($transcation1)
        );

        $transcation2 = new Transaction($this->account, 'withdraw', 500, 'EUR', '2022-05-30');

        $this->assertEquals(
            0,
            $this->account->withdrawalCharge($transcation2)
        );

        $transcation3 = new Transaction($this->account, 'withdraw', 100, 'EUR', '2022-06-01');

        $this->assertEquals(
            0,
            $this->account->withdrawalCharge($transcation3)
        );
    }
}