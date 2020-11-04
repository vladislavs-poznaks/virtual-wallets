<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WalletFeaturesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_wallet_can_be_created_and_it_has_to_be_with_a_unique_name()
    {
        $EXPECTED_WALLET_COUNT = 1;
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->followingRedirects()->post(route('wallets.store'), [
            'name' => 'Test Wallet',
            'amount' => 350
        ]);

        $this->assertCount($EXPECTED_WALLET_COUNT, $user->wallets);

        $this->actingAs($user)->post(route('wallets.store'), [
            'name' => 'Test Wallet',
            'amount' => 100
        ]);

        $this->get(route('dashboard'))
            ->assertSee('Test Wallet');
    }

    /** @test */
    public function a_user_can_rename_a_wallet()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $wallet = Wallet::factory()->create([
            'user_id' => $user->id,
            'name' => 'Test Wallet',
        ]);

        $this->get(route('dashboard'))
            ->assertSee('Test Wallet');

        $response = $this->followingRedirects()->patch(route('wallets.update', ['wallet' => $wallet]), [
            'name' => 'Renamed Wallet'
        ]);

        $response->assertDontSee('Test Wallet');
        $response->assertSee('Renamed Wallet');
    }

    /** @test */
    public function a_user_can_delete_a_wallet()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $wallet = Wallet::factory()->create([
            'user_id' => $user->id,
            'name' => 'Test Wallet',
        ]);

        $this->get(route('dashboard'))
            ->assertSee('Test Wallet');

        $response = $this->followingRedirects()->delete(route('wallets.destroy', ['wallet' => $wallet]));

        $response->assertDontSee('Test Wallet');
    }
}
