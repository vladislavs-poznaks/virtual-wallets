<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionStoreRequest;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Rules\RecipientWalletIsDifferent;
use App\Rules\SenderHasSufficientFunds;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransactionsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Illuminate\Http\Request $request
     * @param Wallet $wallet
     * @return //Illuminate\Http\RedirectResponse
     */
    public function store(TransactionStoreRequest $request, Wallet $wallet)
    {
        $recipient = Wallet::find($request->partner);

        $cents = $request->amount * 100;

        $wallet->withdraw($cents, $recipient);
        $recipient->deposit($cents, $wallet);

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

        return redirect(route('wallets.show', ['wallet' => $wallet]))
            ->with('status', 'Transaction successfully deleted!');
    }
}
