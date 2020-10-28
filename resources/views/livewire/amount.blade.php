<div class="space-y-4">
    <div class="flex space-x-2">
{{--        <div>$100</div>--}}
        <input
            wire:model="amount"
            type="range"
            min="100"
            max="500"
            id="amount"
            name="amount"
            required
            class="w-full"
        >
{{--        <div>$500</div>--}}
    </div>

    <h2 class="text-center font-bold text-2xl">
        ${{ $amount }}
    </h2>
</div>
