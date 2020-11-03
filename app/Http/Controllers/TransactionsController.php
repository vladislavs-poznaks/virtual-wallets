<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionStoreRequest;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class TransactionsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param TransactionStoreRequest $request
     * @param Wallet $wallet
     * @return RedirectResponse
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
     * @param Request $request
     * @param Wallet $wallet
     * @param Transaction $transaction
     * @return RedirectResponse
     */
    public function update(Request $request, Wallet $wallet, Transaction $transaction)
    {
        $transaction->toggleFraud();

        return redirect(route('wallets.show', ['wallet' => $wallet]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Wallet $wallet
     * @param Transaction $transaction
     * @return RedirectResponse
     */
    public function destroy(Wallet $wallet, Transaction $transaction)
    {
        $transaction->delete();

        return redirect(route('wallets.show', ['wallet' => $wallet]))
            ->with('status', 'Transaction successfully deleted!');
    }
}
