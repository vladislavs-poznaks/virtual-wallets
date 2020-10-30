<?php

use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\WalletsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [WalletsController::class, 'index'])->name('dashboard');
    Route::get('/', function () {
        return view('dashboard');
    });

    Route::resource('wallets', WalletsController::class)->only([
        'show', 'store', 'update', 'destroy'
    ]);

    Route::resource('wallets.transactions', TransactionsController::class)->only([
        'store', 'update', 'destroy'
    ]);
});

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();





