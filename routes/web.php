<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WalletsController;
use App\Http\Controllers\TransactionsController;

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
    Route::get('/', [WalletsController::class, 'index']);
    Route::get('/dashboard', [WalletsController::class, 'index'])->name('home');

    Route::post('/wallets', [WalletsController::class, 'store']);

    Route::get('/wallets/{id}', [WalletsController::class, 'show']);

    Route::patch('/wallets/{id}', [WalletsController::class, 'update']);
    Route::delete('/wallets/{id}', [WalletsController::class, 'destroy']);

    Route::post('/wallets/{id}/transactions', [TransactionsController::class, 'store']);
    Route::patch('/wallets/{walletId}/transactions/{id}', [TransactionsController::class, 'update']);
    Route::delete('/wallets/{walletId}/transactions/{id}', [TransactionsController::class, 'destroy']);

});

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();





