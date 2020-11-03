<a href="{{ route('wallets.show', ['wallet' => $wallet]) }}">
    <div class="{{ $loop->last ? '' : 'border-b border-gray-700' }} px-4 py-4 space-y-2 hover:bg-gray-700 cursor-pointer">
        <div class="flex justify-between font-bold text-xl">
            <div>
                {{ $wallet->name }}
            </div>
            <div>
                {{ $wallet->funds }}
            </div>
        </div>
    </div>
</a>
