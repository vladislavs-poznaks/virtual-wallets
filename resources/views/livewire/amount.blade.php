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

    <div class="text-center font-semibold">
        Amount ${{ $amount }}
    </div>
</div>
