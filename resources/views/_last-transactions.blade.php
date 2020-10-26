<div class="bg-gray-700 rounded-lg w-full h-64 px-4 py-6">
    <h3>Last Transactions</h3>
    <div class="mt-4 space-y-2">
        @foreach(range(1, 5) as $item)
                <div class="flex space-x-2">
                    <div class="text-red-700">
                        -$200
                    </div>
                    <a href="#" class="hover:underline">
                        from Wallet #{{ $item }}
                    </a>
                </div>
        @endforeach
    </div>
</div>
