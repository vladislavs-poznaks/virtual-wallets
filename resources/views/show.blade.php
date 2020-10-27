@extends('layouts.app')

@section('content')

    <div class="flex">
        <div class="flex w-1/6">
            @include('_sidebar-links')
        </div>

        <div class="w-1/2 space-y-4">

            @include('_wallet-header')

            @include('_create-transaction')

            <div class="border border-gray-700 rounded-lg mt-10">
                <h3 class="border-b border-gray-700 px-4 py-6">Transactions</h3>

{{--                @foreach()--}}
                    @include('_transaction')
{{--                @endforeach--}}
            </div>

        </div>
        <div class="flex w-1/4 ml-20">
            @include('_wallets-summary')
        </div>
    </div>


@endsection
