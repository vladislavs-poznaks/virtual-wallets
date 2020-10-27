<div class="border border-gray-700 rounded-lg px-4 py-6">

    <h3>Wallet: "{{ $wallet->name }}"</h3>

    <form action="/wallets/{{ $wallet->id }}" method="POST" class="space-y-6">

        @method('PATCH')
        @csrf

        <div class="flex items-center">
            <label
                for="name"
                class="w-1/5"
            >Enter new name</label>
            <input
                type="text"
                id="name"
                name="name"
                placeholder="Enter a unique wallet's name..."
                required
                class="bg-gray-800 text-sm rounded-full focus:outline-none focus:shadow-outline px-3 py-2 ml-4 w-4/5"
            >

        </div>
        @error('name')
            <div class="text-sm text-red-500">{{ $message }}</div>
        @enderror

        <div class="text-center">
            <button
                type="submit"
                class="bg-gray-700 rounded-full px-10 py-2 hover:scale-125"
            >Rename</button>
        </div>
    </form>

    <form action="/wallets/{{ $wallet->id }}" method="POST" class="mt-4">
        @method('DELETE')
        @csrf

        <div class="text-center">
            <button
                type="submit"
                class="bg-gray-700 rounded-full px-10 py-2 hover:scale-125"
            >Delete this wallet</button>
        </div>
    </form>

</div>



