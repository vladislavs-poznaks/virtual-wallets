<?php

namespace Tests\Unit;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function a_user_has_a_name_and_an_email()
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'Test Email',
        ]);

        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('Test Email', $user->email);
    }

    /** @test */
    public function a_user_can_have_one_or_more_transactions()
    {
        $WALLET_COUNT = 2;
        $WALLET_INITIAL_BALANCE = 10000;
        // There are two transactions for each operation (debit & credit)
        $TRANSACTION_COUNT = 4;
        $TRANSACTION_AMOUNT_IN_CENTS = 1000;

        $user = User::factory()->create(['id' => 10]);
        $this->actingAs($user);

        $wallet = Wallet::factory()->create([
            'user_id' => $user->id,
            'cents' => $WALLET_INITIAL_BALANCE
        ]);

        $partner = Wallet::factory()->create([
            'user_id' => $user->id
        ]);

        $wallet->withdraw($TRANSACTION_AMOUNT_IN_CENTS, $partner);
        $partner->deposit($TRANSACTION_AMOUNT_IN_CENTS, $wallet);

        $wallet->withdraw($TRANSACTION_AMOUNT_IN_CENTS, $partner);
        $partner->deposit($TRANSACTION_AMOUNT_IN_CENTS, $wallet);

        $this->assertCount($TRANSACTION_COUNT, $user->transactions);
        $this->assertCount($WALLET_COUNT, $user->wallets);
    }

    /** @test */
    public function a_user_can_have_one_or_more_wallets()
    {
        $WALLET_COUNT = 5;

        $user = User::factory()->create(['id' => 3]);
        // User wallets
        $wallet = Wallet::factory()->count($WALLET_COUNT)->create([
            'user_id' => $user->id
        ]);
        // Other user wallets
        Wallet::factory()->count($WALLET_COUNT)->create([
            'user_id' => User::factory()->create()
        ]);

        $this->assertCount($WALLET_COUNT, $user->wallets);
    }

}
