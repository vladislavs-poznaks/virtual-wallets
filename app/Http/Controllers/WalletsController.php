<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Rules\ValidAmount;

class WalletsController extends Controller
{
    public function show($id)
    {

        return view('show', [
            'wallet' => Wallet::where('id', $id)->first(),
        ]);
    }

    public function store()
    {
        $attributes = request()->validate([
            'name' => ['required', 'alpha_num', 'unique:wallets', 'max:50'],
            'amount' => ['required', new ValidAmount()]
        ]);

        Wallet::create([
            'user_id' => auth()->user()->id,
            'name' => $attributes['name'],
            'amount' => $attributes['amount'] * 100
        ]);

        return redirect('home');
    }

    public function update($id)
    {
        $attributes = request()->validate([
            'name' => ['required', 'alpha_num', 'unique:wallets', 'max:50']
        ]);

        $wallet = Wallet::find($id);
        $wallet->name = $attributes['name'];

        $wallet->save();

        return redirect('/wallets/' . $id);
    }

    public function destroy($id)
    {
        Wallet::destroy($id);

        return redirect('home');
    }
}
