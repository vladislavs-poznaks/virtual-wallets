<?php

namespace Tests\Unit;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WalletTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function a_wallet_has_a_name_and_a_balance()
    {
        $wallet = Wallet::factory()->create([
            'user_id' => User::factory()->create(),
            'name' => 'Test Wallet',
            'cents' => 350
        ]);

        $this->assertEquals('Test Wallet', $wallet->name);
        $this->assertEquals(350, $wallet->cents);
    }

    /**
     * @test
     */
    public function a_wallet_belongs_to_a_user()
    {
        $user = User::factory()->create([
            'id' => 10
        ]);

        $wallet = Wallet::factory()->create([
            'id' => 5,
            'user_id' => $user->id
        ]);

        Wallet::factory()->count(5)->create([
            'user_id' => User::factory()->create()
        ]);

        $this->assertEquals(10, $wallet->user->id);
    }

    /**
     * @test
     */
    public function a_wallet_can_have_one_or_more_debit_and_credit_transactions()
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

        // Two transactions from walletOne to walletTwo
        Transaction::factory()->count(2)->create([
            'id' => 10,
            'user_id' => $user->id,
            'from_wallet_id' => $walletOne->id,
            'to_wallet_id' => $walletTwo->id,
            'cents' => 1000
        ]);

        // One transactions from walletTwo to walletOne
        Transaction::factory()->create([
            'id' => 10,
            'user_id' => $user->id,
            'from_wallet_id' => $walletTwo->id,
            'to_wallet_id' => $walletOne->id,
            'cents' => 500
        ]);

        $this->assertCount(2, $walletTwo->debitTransactions);
        $this->assertCount(1, $walletOne->debitTransactions);

        $this->assertCount(2, $walletOne->creditTransactions);
        $this->assertCount(1, $walletTwo->creditTransactions);

        $this->assertEquals(2000, $walletTwo->debitTransactions->pluck('cents')->sum());
        $this->assertEquals(500, $walletTwo->creditTransactions->pluck('cents')->sum());
    }

    /**
     * @test
     */
    public function funds_can_be_withdrawn_and_deposited_to_a_wallet()
    {
        $wallet = Wallet::factory()->create([
            'user_id' => User::factory()->create(),
            'cents' => 10000
        ]);

        $wallet->withdraw(5000);
        $wallet->withdraw(50000);

        $this->assertEquals(5000, $wallet->cents);

        $wallet->deposit(5000);

        $this->assertEquals(10000, $wallet->cents);

    }
}
