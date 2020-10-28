<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use App\Rules\DifferentWallet;
use App\Rules\SufficientFunds;

class TransactionsController extends Controller
{
    public function store($id)
    {
        $fromWallet = Wallet::find($id);

        $attributes = request()->validate([
            'to' => ['required', new DifferentWallet($fromWallet->id), 'exists:wallets,id'],
            'amount' => ['required', new SufficientFunds((int) $fromWallet->cents)]
        ]);

        $toWallet = Wallet::find($attributes['to']);
        $cents = $attributes['amount'] * 100;

        $fromWallet->withdraw($cents);
        $toWallet->deposit($cents);

        Transaction::create([
            'user_id' => auth()->user()->id,
            'from_wallet_id' => $fromWallet->id,
            'to_wallet_id' => $toWallet->id,
            'cents' => $cents
        ]);

        return redirect('/wallets/' . $id);
    }

    public function update($walletId, $id)
    {
        Transaction::find($id)->toggleFraud();

        return redirect('/wallets/' . $walletId);
    }

    public function destroy($walletId, $id)
    {
        Transaction::destroy($id);

        return redirect('/wallets/' . $walletId);
    }
}
