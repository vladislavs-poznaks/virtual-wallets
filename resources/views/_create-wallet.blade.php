<div class="border border-gray-700 rounded-lg px-4 py-6">
    <h3>Create New Wallet</h3>
    <form action="{{ route('wallets.store') }}" method="POST" class="space-y-6">

        @csrf

        <div class="flex items-center">
            <label
                for="name"
                class="w-1/5"
            >Wallet's Name</label>
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
        <livewire:amount/>
        <div class="text-center">
            <button
                type="submit"
                class="bg-gray-700 rounded-full px-10 py-2 hover:scale-125"
            >Create</button>
        </div>
    </form>
</div>



