@extends('layouts.app')

@section('content')

    <div class="flex">
        <div class="flex w-1/6">
            @include('_sidebar-links')
        </div>
        <div class="w-1/2">
            @include('_create-wallet')

            @include('_wallets-index')
        </div>
        <div class="flex w-1/4 ml-20">
            @include('_last-transactions')
        </div>
    </div>


@endsection
