@extends('layouts.app')

@section('content')

    <div class="flex">
        <div class="flex w-1/6">
            @include('sidebars._nav')
        </div>

        <div class="w-1/2 space-y-4">

            @include('wallets._wallet-edit')

            @include('transactions.transaction-create')

            @if(session('status'))
                <div class="text-sm text-red-500 mt-10 text-center">
                    {{ session('status') }}
                </div>
            @endif

            <div class="border border-gray-700 rounded-lg mt-10">
                <h3 class="border-b border-gray-700 px-4 py-6">Transactions</h3>

                @forelse($transactions as $transaction)
                    @include('transactions._transaction')
                @empty
                    <div class="px-4 py-6">
                        No transactions with this wallet...
                    </div>
                @endforelse
            </div>
        </div>
        <div class="flex w-1/4 ml-20">
            @include('sidebars._other-wallets')
        </div>
    </div>


@endsection
