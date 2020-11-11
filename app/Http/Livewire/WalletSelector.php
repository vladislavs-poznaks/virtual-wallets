<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Wallet;
use Livewire\Component;

class WalletSelector extends Component
{
    public $recipient;
    public $wallet;

    public function render()
    {
        $wallets = Wallet::where('user_id', $this->recipient ?? auth()->user()->id)
            ->get()
            ->except($this->wallet->id);

        return view('livewire.wallet-selector', [
            'users' => User::all(),
            'wallets' => $wallets
        ]);
    }
}
