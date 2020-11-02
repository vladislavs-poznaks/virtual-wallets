<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use App\Rules\DifferentWallet;
use App\Rules\SufficientFunds;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransactionsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Wallet $wallet
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Wallet $wallet)
    {

        $request->validate([
            'to' => ['required', new DifferentWallet($wallet->id), 'exists:wallets,id'],
            'amount' => ['required', new SufficientFunds((int) $wallet->cents)]
        ]);

        $toWallet = Wallet::find($request['to']);
        $cents = $request['amount'] * 100;

        $wallet->withdraw($cents);
        $toWallet->deposit($cents);

        Transaction::create([
            'id' => Str::uuid(),
            'user_id' => auth()->user()->id,
            'from_wallet_id' => $wallet->id,
            'to_wallet_id' => $toWallet->id,
            'cents' => $cents
        ]);

        return redirect(route('wallets.show', ['wallet' => $wallet]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Wallet $wallet
     * @param \App\Models\Transaction $transaction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Wallet $wallet, Transaction $transaction)
    {
        $transaction->toggleFraud();

        return redirect(route('wallets.show', ['wallet' => $wallet]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Wallet $wallet
     * @param \App\Models\Transaction $transaction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Wallet $wallet, Transaction $transaction)
    {
        $transaction->delete();

        return redirect(route('wallets.show', ['wallet' => $wallet]));
    }
}
