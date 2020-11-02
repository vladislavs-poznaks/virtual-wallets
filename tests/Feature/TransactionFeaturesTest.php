<?php

namespace Tests\Feature;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionFeaturesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_transaction_between_two_wallets_can_be_created()
    {
        $user = User::factory()->create();

        $walletOne = Wallet::factory()->create([
            'user_id' => $user->id,
            'name' => 'Wallet One',
            'cents' => 10000
        ]);

        $walletTwo = Wallet::factory()->create([
            'user_id' => $user->id,
            'name' => 'Wallet Two',
            'cents' => 10000
        ]);

        $this->actingAs($user)->post(route('wallets.transactions.store', ['wallet' => $walletOne]), [
            'to' => $walletTwo->id,
            'amount' => 5
        ])
            ->assertRedirect(route('wallets.show', ['wallet' => $walletOne]));

        $this->actingAs($user)->get(route('wallets.show', ['wallet' => $walletOne]))
            ->assertSee('-$5.00');

        $this->actingAs($user)->get(route('wallets.show', ['wallet' => $walletTwo]))
            ->assertSee('+$5.00');
    }

    /**
     * @test
     */
    public function a_total_of_debit_and_credit_transactions_can_be_seen_in_a_wallet()
    {
        $user = User::factory()->create();

        $walletOne = Wallet::factory()->create([
            'id' => 1,
            'user_id' => $user->id,
            'name' => 'Wallet One',
            'cents' => 10000
        ]);

        $walletTwo = Wallet::factory()->create([
            'id' => 2,
            'user_id' => $user->id,
            'name' => 'Wallet Two',
            'cents' => 10000
        ]);

        Transaction::factory()->count(3)->create([
            'user_id' => $user->id,
            'from_wallet_id' => $walletOne->id,
            'to_wallet_id' => $walletTwo->id,
            'cents' => 500
        ]);

        Transaction::factory()->count(2)->create([
            'user_id' => $user->id,
            'from_wallet_id' => $walletTwo->id,
            'to_wallet_id' => $walletOne->id,
            'cents' => 1000
        ]);

        $this->actingAs($user)->get(route('wallets.show', ['wallet' => $walletOne]))
            ->assertSee('- $15');

        $this->actingAs($user)->get(route('wallets.show', ['wallet' => $walletOne]))
            ->assertSee('+ $20');
    }

    /**
     * @test
     */
    public function a_transaction_can_be_marked_and_unmarked_as_fraudulent()
    {
        $user = User::factory()->create();

        $walletOne = Wallet::factory()->create([
            'id' => 1,
            'user_id' => $user->id,
            'name' => 'Wallet One',
            'cents' => 10000
        ]);

        $walletTwo = Wallet::factory()->create([
            'id' => 2,
            'user_id' => $user->id,
            'name' => 'Wallet Two',
            'cents' => 10000
        ]);

        $transaction = Transaction::factory()->create([
            'id' => 'test_id',
            'user_id' => $user->id,
            'from_wallet_id' => $walletOne->id,
            'to_wallet_id' => $walletTwo->id,
            'cents' => 500
        ]);

        $this->actingAs($user)->patch(route('wallets.transactions.update', [
            'wallet' => $walletOne,
            'transaction' => $transaction
        ]))
            ->assertRedirect(route('wallets.show', ['wallet' => $walletOne]));

        $this->actingAs($user)->get(route('wallets.show', ['wallet' => $walletOne]))
            ->assertSee('Marked as Fraudulent');

        $this->actingAs($user)->patch(route('wallets.transactions.update', [
            'wallet' => $walletOne,
            'transaction' => $transaction
        ]))
            ->assertRedirect(route('wallets.show', ['wallet' => $walletOne]));

        $this->actingAs($user)->get(route('wallets.show', ['wallet' => $walletOne]))
            ->assertDontSee('Marked as Fraudulent');
    }

    /**
     * @test
     */
    public function a_transaction_can_be_deleted()
    {
        $user = User::factory()->create();

        $walletOne = Wallet::factory()->create([
            'id' => 1,
            'user_id' => $user->id,
            'name' => 'Wallet One',
            'cents' => 10000
        ]);

        $walletTwo = Wallet::factory()->create([
            'id' => 2,
            'user_id' => $user->id,
            'name' => 'Wallet Two',
            'cents' => 10000
        ]);

        Transaction::factory()->count(3)->create([
            'user_id' => $user->id,
            'from_wallet_id' => $walletOne->id,
            'to_wallet_id' => $walletTwo->id,
            'cents' => 1000
        ]);

        $transaction = Transaction::factory()->create([
            'id' => 'test_id',
            'user_id' => $user->id,
            'from_wallet_id' => $walletOne->id,
            'to_wallet_id' => $walletTwo->id,
            'cents' => 500
        ]);

        $this->actingAs($user)->get(route('wallets.show', ['wallet' => $walletOne]))
            ->assertSee('-$5.00');

        $this->actingAs($user)->delete(route('wallets.transactions.destroy', [
            'wallet' => $walletOne,
            'transaction' => $transaction
        ]))
            ->assertRedirect(route('wallets.show', ['wallet' => $walletOne]));

        $this->actingAs($user)->get(route('wallets.show', ['wallet' => $walletOne]))
            ->assertDontSee('-$5.00');
    }
}
