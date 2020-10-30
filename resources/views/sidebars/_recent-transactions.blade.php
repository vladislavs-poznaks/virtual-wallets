<div class="bg-gray-700 rounded-lg w-full h-64 px-4 py-6">
    <h3>Last Transactions</h3>
    <div class="mt-4 space-y-2">
        @forelse($transactions as $transaction)
            <div class="flex space-x-2">
                <div>
                    {{ $transaction->formattedFunds() }} from
                </div>
                <a href="{{ route('wallets.show', ['wallet' => $transaction->fromWallet]) }}" class="hover:underline">
                    {{ $transaction->fromWallet->name }}
                </a>
                <div> to </div>
                <a href="{{ route('wallets.show', ['wallet' => $transaction->toWallet]) }}" class="hover:underline">
                    {{ $transaction->toWallet->name }}
                </a>
            </div>
        @empty
            No transactions yet...
        @endforelse
    </div>
</div>
