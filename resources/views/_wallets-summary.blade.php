<div class="bg-gray-700 rounded-lg w-full h-64 px-4 py-6">
    <h3>Your Wallets</h3>
    <div class="mt-4 space-y-2">
        @foreach($availableWallets as $wallet)
            <div class="flex justify-between">
                <a href="/wallets/{{ $wallet->id }}">
                    {{ $wallet->name }}
                </a>
                <div>
                    Funds: ${{ $wallet->amount / 100 }}
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
                + $1000
            </span>
        </div>
        <div>
            <span>
                Total credit:
            </span>
            <span class="text-red-500">
                - $1000
            </span>
        </div>

    </div>
</div>
