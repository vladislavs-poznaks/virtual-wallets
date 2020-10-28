@extends('layouts.app')

@section('content')
    <div class="flex">
        <div class="flex w-1/6">
            @include('_sidebar-links')
        </div>

        <div class="w-1/2">

            @include('_create-wallet')

            <div class="border border-gray-700 rounded-lg mt-10">
                <h3 class="border-b border-gray-700 px-4 py-6">My Wallets</h3>
                @forelse($wallets as $wallet)
                    @include('_wallet')
                @empty
                    No wallets yet... Create one!
                @endforelse
            </div>

        </div>
        <div class="flex w-1/4 ml-20">
            @include('_last-transactions')
        </div>
    </div>
@endsection
