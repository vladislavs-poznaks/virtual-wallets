<?php

namespace Tests\Unit;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class TransactionTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function a_transaction_has_an_amount_of_funds_transferred()
    {
        $WALLET_INITIAL_BALANCE = 10000;
        $TRANSACTION_AMOUNT = 500;

        $EXPECTED_CREDIT_AMOUNT = -500;
        $EXPECTED_DEBIT_AMOUNT = 500;

        $user = User::factory()->create(['id' => 10]);
        $this->actingAs($user);

        $wallet = Wallet::factory()->create([
            'user_id' => $user->id,
            'cents' => $WALLET_INITIAL_BALANCE
        ]);

        $partner = Wallet::factory()->create([
            'user_id' => $user->id
        ]);

        $wallet->withdraw($TRANSACTION_AMOUNT, $partner);
        $partner->deposit($TRANSACTION_AMOUNT, $wallet);

        $this->assertEquals($EXPECTED_CREDIT_AMOUNT, $wallet->transactions->first()->cents);
        $this->assertEquals($EXPECTED_DEBIT_AMOUNT, $partner->transactions->first()->cents);
    }

    /** @test */
    public function a_transaction_belongs_to_two_separate_wallets()
    {
        $WALLET_INITIAL_BALANCE = 10000;
        $TRANSACTION_AMOUNT = 500;

        $EXPECTED_CREDIT_AMOUNT = -500;
        $EXPECTED_DEBIT_AMOUNT = 500;

        $user = User::factory()->create(['id' => 10]);
        $this->actingAs($user);

        $wallet = Wallet::factory()->create([
            'user_id' => $user->id,
            'name' => 'Test Wallet One',
            'cents' => $WALLET_INITIAL_BALANCE
        ]);

        $partner = Wallet::factory()->create([
            'user_id' => $user->id,
            'name' => 'Test Wallet Two'
        ]);

        $wallet->withdraw($TRANSACTION_AMOUNT, $partner);
        $partner->deposit($TRANSACTION_AMOUNT, $wallet);

        $transaction = Transaction::where('wallet_id', $wallet->id)->first();

        $this->assertEquals('Test Wallet One', $transaction->wallet->name);

        $transaction = Transaction::where('wallet_id', $partner->id)->first();

        $this->assertEquals('Test Wallet Two', $transaction->wallet->name);
    }
}
