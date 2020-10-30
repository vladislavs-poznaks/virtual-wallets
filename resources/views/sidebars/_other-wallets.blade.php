<div class="bg-gray-700 rounded-lg w-full px-4 py-6">
    <h3>Your Other Wallets</h3>
    <div class="mt-4 space-y-2">
        @foreach($availableWallets as $wallet)
            <div class="flex justify-between">
                <a href="{{ route('wallets.show', ['wallet' => $wallet]) }}" class="hover:underline">
                    {{ $wallet->name }}
                </a>
                <div>
                    {{ $wallet->formattedFunds() }}
                </div>
            </div>
        @endforeach
    </div>

    <div class="space-y-2 mt-5">
        <div>
            <span>
                Total debit:
            </span>
            <span class="text-green-500">
                + ${{ $debitTransactions->sum('cents') / 100 }}
            </span>
        </div>
        <div>
            <span>
                Total credit:
            </span>
            <span class="text-red-500">
                - ${{ $creditTransactions->sum('cents') / 100 }}
            </span>
        </div>

    </div>
</div>
