<div class="bg-gray-700 rounded-lg w-full h-64 px-4 py-6">
    <h3>Last Transactions</h3>
    <div class="mt-4 space-y-2">
        @forelse($transactions as $transaction)
            <div class="flex space-x-2">
                <div>
                    {{ $transaction->amount }} from
                </div>
                @if($transaction->wallet)
                <a href="{{ route('wallets.show', ['wallet' => $transaction->wallet]) }}" class="hover:underline">
                    {{ $transaction->wallet->name }}
                </a>
                @else
                <div>(Wallet Deleted)</div>
                @endif
            </div>
        @empty
            No transactions yet...
        @endforelse
    </div>
</div>
