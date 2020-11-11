<div class="border border-gray-700 rounded-lg px-4 py-6">
    <h3>Create New Transaction</h3>
    <form action="{{ route('wallets.transactions.store', ['wallet' => $wallet]) }}" method="POST" class="space-y-6">
        @csrf

        <livewire:wallet-selector :wallet="$wallet"/>

        <div class="text-right">
            <button
                type="submit"
                class="bg-gray-700 rounded-full px-10 py-2 hover:scale-125"
            >Send Money</button>
        </div>
    </form>
</div>



