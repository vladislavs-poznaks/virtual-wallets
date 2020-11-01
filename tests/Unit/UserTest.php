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

    /**
     * @test
     */
    public function a_user_has_a_name_and_an_email()
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'Test Email',
        ]);

        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('Test Email', $user->email);
    }

    /**
     * @test
     */
    public function a_user_can_have_one_or_more_wallets()
    {
        $user = User::factory()->create(['id' => 3]);

        $wallet = Wallet::factory()->count(5)->create([
            'user_id' => $user->id
        ]);

        Wallet::factory()->count(5)->create([
            'user_id' => User::factory()->create()
        ]);

        $this->assertCount(5, $user->wallets);
    }

    /**
     * @test
     */
    public function a_user_can_have_one_or_more_transactions()
    {
        $user = User::factory()->create(['id' => 10]);

        $walletFrom = Wallet::factory()->create([
            'id' => 1,
            'user_id' => $user->id,
            'cents' => 10000
        ]);

        $walletTo = Wallet::factory()->create([
            'id' => 2,
            'user_id' => $user->id
        ]);

        $transaction = Transaction::factory()->count(2)->create([
            'id' => 10,
            'user_id' => $user->id,
            'from_wallet_id' => $walletFrom->id,
            'to_wallet_id' => $walletTo->id,
            'cents' => 1000
        ]);

        $this->assertCount(2, $user->transactions);
        $this->assertCount(2, $user->wallets);
    }

}
