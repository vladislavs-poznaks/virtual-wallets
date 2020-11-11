<div class="space-y-6">
    <div class="flex items-center">
        <label
            for="recipient"
            class="w-1/5"
        >Recipient</label>
        <select
            wire:model="recipient"
            type="text"
            id="recipient"
            name="recipient"
            required
            class="bg-gray-800 text-sm rounded-full focus:outline-none focus:shadow-outline px-3 py-2 ml-4 w-4/5"
        >
            @foreach($users as $recipient)
                <option
                    value="{{ $recipient->id }}"
                    {{ $recipient->is(auth()->user()) ? 'selected' : '' }}
                >{{ $recipient->is(auth()->user()) ? 'My Wallets' : $recipient->name }}
                </option>
            @endforeach
        </select>
    </div>
    @error('recipient')
    <div class="text-sm text-red-500">{{ $message }}</div>
    @enderror

    @if(count($wallets) > 0)
    <div class="flex items-center">
        <label
            for="partner"
            class="w-1/5"
        >Wallet</label>
        <select
            type="text"
            id="partner"
            name="partner"
            required
            class="bg-gray-800 text-sm rounded-full focus:outline-none focus:shadow-outline px-3 py-2 ml-4 w-4/5"
        >
            @foreach($wallets as $walletTo)
                <option value="{{ $walletTo->id }}">{{ $walletTo->name }}</option>
            @endforeach
        </select>
    </div>
    @error('partner')
    <div class="text-sm text-red-500">{{ $message }}</div>
    @enderror
    <div class="flex items-center">
        <label
            for="amount"
            class="w-1/5"
        >Amount</label>
        <input
            type="number"
            id="amount"
            name="amount"
            min="1"
            max="{{ $wallet->cents / 100 }}"
            placeholder="Enter amount..."
            required
            class="bg-gray-800 text-sm rounded-full focus:outline-none focus:shadow-outline px-3 py-2 ml-4 w-4/5"
        >
    </div>
    @error('amount')
    <div class="text-sm text-red-500">{{ $message }}</div>
    @enderror
    @else
        <div>Recipient has no wallets...</div>
    @endif
</div>
