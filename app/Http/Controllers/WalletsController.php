<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Rules\ValidAmount;

class WalletsController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'wallets' => auth()->user()->wallets,
            'transactions' => auth()->user()->transactions->take(5)
        ]);
    }

    public function show($id)
    {
        $wallet = Wallet::where('id', $id)->first();

        return view('show', [
            'wallet' => $wallet,
            'availableWallets' => auth()->user()->wallets->except($id),
            'debitTransactions' => $wallet->debitTransactions,
            'creditTransactions' => $wallet->creditTransactions,
            'transactions' => $wallet->transactions()
        ]);
    }

    public function store()
    {
        $attributes = request()->validate([
            'name' => ['required', 'unique:wallets', 'max:20'],
            'amount' => ['required', new ValidAmount()]
        ]);

        Wallet::create([
            'user_id' => auth()->user()->id,
            'name' => $attributes['name'],
            'cents' => $attributes['amount'] * 100
        ]);

        return redirect('/dashboard');
    }

    public function update($id)
    {
        $attributes = request()->validate([
            'name' => ['required', 'unique:wallets', 'max:50']
        ]);

        $wallet = Wallet::find($id);
        $wallet->name = $attributes['name'];

        $wallet->save();

        return redirect('/wallets/' . $id);
    }

    public function destroy($id)
    {
        Wallet::destroy($id);

        return redirect('/dashboard');
    }
}
