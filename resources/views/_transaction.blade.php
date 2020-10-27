 <div class="border-b border-gray-700 px-4 py-4 space-y-2">
    <div class="flex justify-between items-center">
        <div class="flex space-x-3">
            <div class="text-green-700">
                +$200
            </div>
            <div>
                from Wallet's Name
            </div>
            <div>
                3 day ago
            </div>
        </div>

        <div class="flex space-x-3">
            <form action="/wallets/{{ $wallet->id }}/transactions/TRANSACTION-ID" method="POST">
                @method('DELETE')
                @csrf

                <button
                    type="submit"
                    class="bg-gray-700 rounded-full px-10 py-2 hover:scale-125"
                >
                    Delete
                </button>
            </form>
            <form action="/wallets/{{ $wallet->id }}/transactions/TRANSACTION-ID/fraudulent" method="POST">

                @csrf

                <button
                    type="submit"
                    class="bg-gray-700 rounded-full px-10 py-2 hover:scale-125"
                >
                    Fraudulent
                </button>
            </form>
        </div>
    </div>
 </div>
