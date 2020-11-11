<?php

namespace App\Http\Controllers;

use App\Http\Requests\WalletStoreRequest;
use App\Http\Requests\WalletUpdateRequest;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
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
     * @param WalletStoreRequest $request
     * @return RedirectResponse
     */
    public function store(WalletStoreRequest $request)
    {
        Wallet::create([
            'id' => Str::uuid(),
            'user_id' => auth()->user()->id,
            'name' => $request->name,
            'cents' => $request->amount * 100
        ]);

        return redirect(route('dashboard'));
    }

    /**
     * Display the specified resource.
     *
     * @param Wallet $wallet
     * @return Response
     */
    public function show(Wallet $wallet)
    {
        return response()->view('show', [
            'wallet' => $wallet,
            'transactions' => $wallet->transactions,
            'otherWallets' => auth()->user()->wallets->except($wallet->id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param WalletUpdateRequest $request
     * @param Wallet $wallet
     * @return RedirectResponse
     */
    public function update(WalletUpdateRequest $request, Wallet $wallet)
    {
        $wallet->update([
                'name' => $request->name,
            ]);

        return redirect(route('wallets.show', ['wallet' => $wallet]))
            ->with('status', 'Wallet\'s name has been changed!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Wallet $wallet
     * @return RedirectResponse
     */
    public function destroy(Wallet $wallet)
    {
        $wallet->delete();

        return redirect(route('dashboard'))
            ->with('status', 'Wallet "' . $wallet->name . '" successfully deleted!');
    }
}
