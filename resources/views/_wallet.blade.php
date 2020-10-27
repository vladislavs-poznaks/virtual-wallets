<a href="/wallets/{{ $wallet->id }}">
    <div class="border-b border-gray-700 px-4 py-4 space-y-2 hover:bg-gray-700 cursor-pointer">
        <div class="flex justify-between">
            <div>
                {{ $wallet->name }}
            </div>
            <div>
                Funds remaining: ${{ $wallet->amount / 100 }}
            </div>
        </div>
        <div class="flex">
            <div>
                Last transaction:
            </div>
            <div class="text-green-700 ml-2">
                +$200
            </div>
        </div>
    </div>
</a>
