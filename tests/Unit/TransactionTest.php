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

    /**
     * @test
     */
    public function a_transaction_has_an_amount_of_funds_transferred()
    {
        $user = User::factory()->create(['id' => 10]);

        $walletOne = Wallet::factory()->create([
            'id' => 1,
            'user_id' => $user->id,
            'cents' => 10000
        ]);

        $walletTwo = Wallet::factory()->create([
            'id' => 2,
            'user_id' => $user->id
        ]);

        $transaction = Transaction::factory()->create([
            'id' => 10,
            'user_id' => $user->id,
            'from_wallet_id' => $walletOne->id,
            'to_wallet_id' => $walletTwo->id,
            'cents' => 1000
        ]);

        $this->assertEquals(1000, $transaction->cents);
    }

    /**
     * @test
     */
    public function a_transaction_belongs_to_two_separate_wallets()
    {
        $user = User::factory()->create(['id' => 10]);

        $walletOne = Wallet::factory()->create([
            'id' => 1,
            'name' => 'Test Wallet One',
            'user_id' => $user->id,
        ]);

        $walletTwo = Wallet::factory()->create([
            'id' => 2,
            'name' => 'Test Wallet Two',
            'user_id' => $user->id
        ]);

        $transaction = Transaction::factory()->create([
            'id' => 10,
            'user_id' => $user->id,
            'from_wallet_id' => $walletOne->id,
            'to_wallet_id' => $walletTwo->id,
            'cents' => 1000
        ]);

        $this->assertEquals('Test Wallet One', $transaction->fromWallet->name);
        $this->assertEquals('Test Wallet Two', $transaction->toWallet->name);
    }
}
