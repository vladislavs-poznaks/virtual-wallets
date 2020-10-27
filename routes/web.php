<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WalletsController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/wallets', [WalletsController::class, 'store']);

Route::get('/wallets/{id}', [WalletsController::class, 'show'])->name('wallet.show');
Route::patch('/wallets/{id}', [WalletsController::class, 'update']);
Route::delete('/wallets/{id}', [WalletsController::class, 'destroy']);

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
