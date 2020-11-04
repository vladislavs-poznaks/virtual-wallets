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

    /** @test */
    public function a_wallet_has_a_name_and_a_balance()
    {
        $INITIAL_BALANCE = 35000;

        $wallet = Wallet::factory()->create([
            'user_id' => User::factory()->create(),
            'name' => 'Test Wallet',
            'cents' => $INITIAL_BALANCE
        ]);

        $this->assertEquals('Test Wallet', $wallet->name);
        $this->assertEquals($INITIAL_BALANCE, $wallet->cents);
    }

    /** @test */
    public function a_wallet_belongs_to_a_user()
    {
        $OTHER_WALLET_COUNT = 5;

        $user = User::factory()->create([
            'id' => 10
        ]);

        $wallet = Wallet::factory()->create([
            'id' => 5,
            'user_id' => $user->id
        ]);

        Wallet::factory()->count($OTHER_WALLET_COUNT)->create([
            'user_id' => User::factory()->create()
        ]);

        $this->assertEquals(10, $wallet->user->id);
    }

    /** @test */
    public function a_wallet_can_have_one_or_more_transactions()
    {
        $WALLET_INITIAL_BALANCE = 10000;
        $FIVE_USD_IN_CENTS = 500;
        $TEN_USD_IN_CENTS = 1000;

        $EXPECTED_TRANSACTION_COUNT = 2;

        $TOTAL_EXPECTED_DEBIT = '+$15.00';
        $TOTAL_EXPECTED_CREDIT = '-$15.00';

        $user = User::factory()->create(['id' => 10]);
        $this->actingAs($user);

        $wallet = Wallet::factory()->create([
            'user_id' => $user->id,
            'cents' => $WALLET_INITIAL_BALANCE
        ]);

        $partner = Wallet::factory()->create([
            'user_id' => $user->id
        ]);

        // Transaction #1
        $wallet->withdraw($TEN_USD_IN_CENTS, $partner);
        $partner->deposit($TEN_USD_IN_CENTS, $wallet);

        // Transaction #2
        $wallet->withdraw($FIVE_USD_IN_CENTS, $partner);
        $partner->deposit($FIVE_USD_IN_CENTS, $wallet);


        $this->assertCount($EXPECTED_TRANSACTION_COUNT, $wallet->transactions);
        $this->assertCount($EXPECTED_TRANSACTION_COUNT, $partner->transactions);

        $this->assertEquals($TOTAL_EXPECTED_DEBIT, $partner->debit);
        $this->assertEquals($TOTAL_EXPECTED_CREDIT, $wallet->credit);
    }

    /** @test */
    public function funds_can_be_withdrawn_and_deposited_to_a_wallet()
    {
        $WALLET_INITIAL_BALANCE = 10000;
        $FIVE_USD_IN_CENTS = 500;
        $TEN_USD_IN_CENTS = 1000;

        $EXPECTED_FINAL_BALANCE = 8500;

        $user = User::factory()->create(['id' => 10]);
        $this->actingAs($user);

        $wallet = Wallet::factory()->create([
            'user_id' => $user->id,
            'cents' => $WALLET_INITIAL_BALANCE
        ]);

        $partner = Wallet::factory()->create([
            'user_id' => $user->id
        ]);

        // Transaction #1
        $wallet->withdraw($TEN_USD_IN_CENTS, $partner);
        $partner->deposit($TEN_USD_IN_CENTS, $wallet);

        // Transaction #2
        $wallet->withdraw($FIVE_USD_IN_CENTS, $partner);
        $partner->deposit($FIVE_USD_IN_CENTS, $wallet);

        $this->assertEquals($EXPECTED_FINAL_BALANCE, $wallet->cents);

    }
}
