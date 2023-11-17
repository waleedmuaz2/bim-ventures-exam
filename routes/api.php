<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JWTAuth\AuthController;
use App\Http\Controllers\API\V1\PaymentController;
use App\Http\Controllers\API\V1\TransactionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'auth'], function () {
    Route::post('signup', [AuthController::class, 'signup'])->name('signup');
    Route::post('login', [AuthController::class, 'login'])->name('login');

    Route::group(['middleware' => ['auth.token']], function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::post('refresh', [AuthController::class, 'refresh'])->name('refresh');
        Route::post('me', [AuthController::class, 'me'])->name('me');
        Route::post('home', [TransactionController::class, 'transactionList'])->name('home');
    });
});

Route::group(['prefix'=>'payment','middleware' => ['auth.token','check.admin']], function () {
    Route::post('/store/{id}', [PaymentController::class,'store'])->name('payment..store');
});
Route::group(['prefix'=>'transaction','middleware' => ['auth.token','check.admin']], function () {
    Route::get('/users',[TransactionController::class,'create']);
    Route::post('/store', [TransactionController::class,'store'])->name('transaction..store');
});
