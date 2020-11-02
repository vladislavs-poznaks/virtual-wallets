<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WalletFeaturesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_wallet_can_be_created_and_it_has_to_be_with_a_unique_name()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('wallets.store'), [
            'name' => 'Test Wallet',
            'amount' => 300
        ]);

        $this->actingAs($user)->post(route('wallets.store'), [
            'name' => 'Test Wallet',
            'amount' => 100
        ]);

        $this->assertCount(1, $user->wallets);

        $this->actingAs($user)->get(route('dashboard'))
            ->assertSee('Test Wallet');
    }

    /**
     * @test
     */
    public function a_user_can_rename_a_wallet()
    {
        $user = User::factory()->create();

        $wallet = Wallet::factory()->create([
            'user_id' => $user->id,
            'name' => 'Test Wallet',
        ]);

        $this->actingAs($user)->get(route('dashboard'))
            ->assertSee('Test Wallet');

        $this->actingAs($user)->patch(route('wallets.update', ['wallet' => $wallet]), [
            'name' => 'Renamed Wallet'
        ])->assertRedirect(route('wallets.show', ['wallet' => $wallet]));

        $this->assertEquals('Renamed Wallet', $user->wallets->first()->name);

        $this->actingAs($user)->get(route('dashboard'))
            ->assertSee('Renamed Wallet');
    }

    /**
     * @test
     */
    public function a_user_can_delete_a_wallet()
    {
        $user = User::factory()->create();

        $wallet = Wallet::factory()->create([
            'user_id' => $user->id,
            'name' => 'Test Wallet',
        ]);

        $this->actingAs($user)->get(route('dashboard'))
            ->assertSee('Test Wallet');

        $this->actingAs($user)->delete(route('wallets.destroy', ['wallet' => $wallet]));

        $this->assertCount(0, $user->wallets);

        $this->actingAs($user)->get(route('dashboard'))
            ->assertDontSee('Test Wallet');
    }
}
