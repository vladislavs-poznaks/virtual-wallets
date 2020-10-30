@extends('layouts.app')

@section('content')
    <div class="flex">
        <div class="flex w-1/6">
            @include('sidebars._nav')
        </div>

        <div class="w-1/2">

            @include('wallets._wallet-create')

            <div class="border border-gray-700 rounded-lg mt-10">
                <h3 class="border-b border-gray-700 px-4 py-6">My Wallets</h3>
                @forelse($wallets as $wallet)
                    @include('wallets._wallet')
                @empty
                    <div class="px-4 py-6">
                        No wallets yet... Create one!
                    </div>
                @endforelse
            </div>

        </div>
        <div class="flex w-1/4 ml-20">
            @include('sidebars._recent-transactions')
        </div>
    </div>
@endsection
