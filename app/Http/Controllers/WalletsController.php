<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Rules\ValidAmount;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WalletsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return
     */
    public function index()
    {
        return view('dashboard', [
            'wallets' => auth()->user()->wallets,
            'transactions' => auth()->user()->transactions->take(5)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:wallets', 'max:20'],
            'amount' => ['required', new ValidAmount()]
        ]);

        Wallet::create([
            'id' => Str::uuid(),
            'user_id' => auth()->user()->id,
            'name' => $request['name'],
            'cents' => $request['amount'] * 100
        ]);

        return redirect(route('dashboard'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Wallet $wallet
     * @return \Illuminate\Http\Response
     */
    public function show(Wallet $wallet)
    {
        return response()->view('show', [
            'wallet' => $wallet,
            'availableWallets' => auth()->user()->wallets->except($wallet->id),
            'debitTransactions' => $wallet->debitTransactions,
            'creditTransactions' => $wallet->creditTransactions,
            'transactions' => $wallet->transactions()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Wallet $wallet
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Wallet $wallet)
    {
        $request->validate([
            'name' => ['required', 'unique:wallets', 'max:20']
        ]);

        $wallet->update([
                'name' => $request['name'],
            ]);

        return redirect(route('wallets.show', ['wallet' => $wallet]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Wallet $wallet
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Wallet $wallet)
    {
        $wallet->delete();

        return redirect(route('dashboard'));
    }
}
