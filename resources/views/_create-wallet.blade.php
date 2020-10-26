<div class="border border-gray-700 rounded-lg px-4 py-6">
    <h3>Create New Wallet</h3>
    <form action="/wallets" method="POST" class="space-y-6">

        @csrf

        <div class="flex items-center">
            <label
                for="title"
                class="w-1/5"
            >Wallet's Title</label>
            <input
                type="text"
                id="title"
                name="title"
                placeholder="Enter a unique wallet's title..."
                required
                class="bg-gray-800 text-sm rounded-full focus:outline-none focus:shadow-outline px-3 py-2 ml-4 w-4/5">
        </div>

        <livewire:amount/>

        <div class="text-center">
            <button
                type="submit"
                class="bg-gray-700 rounded-full px-10 py-2 hover:scale-125"
            >Create!</button>
        </div>
    </form>
</div>



