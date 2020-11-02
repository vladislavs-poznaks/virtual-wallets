<div class="border border-gray-700 rounded-lg px-4 py-6">
    <h3>Create New Transaction</h3>
    <form action="{{ route('wallets.transactions.store', ['wallet' => $wallet]) }}" method="POST" class="space-y-6">

        @csrf

        <div class="flex items-center">
            <label
                for="to"
                class="w-1/5"
            >To</label>
            <select
                type="text"
                id="to"
                name="to"
                required
                class="bg-gray-800 text-sm rounded-full focus:outline-none focus:shadow-outline px-3 py-2 ml-4 w-4/5"
            >
                @foreach($availableWallets as $walletTo)
                    <option value="{{ $walletTo->id }}">{{ $walletTo->name }}</option>
                @endforeach
            </select>

        </div>
        @error('to')
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

        <div class="text-right">
            <button
                type="submit"
                class="bg-gray-700 rounded-full px-10 py-2 hover:scale-125"
            >Send Money</button>
        </div>
    </form>
</div>



