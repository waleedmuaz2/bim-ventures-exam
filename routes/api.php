<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JWTAuth\AuthController;
use App\Http\Controllers\API\V1\PaymentController;
use App\Http\Controllers\API\V1\TransactionController;
use App\Http\Controllers\API\V1\ReportController;

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
    Route::post('signup', [AuthController::class, 'signup'])->name('api.signup');
    Route::post('login', [AuthController::class, 'login'])->name('api.sign-in');

    Route::group(['middleware' => ['auth.token']], function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('api.log-out');
        Route::post('refresh', [AuthController::class, 'refresh'])->name('refresh');
        Route::post('me', [AuthController::class, 'me'])->name('me');
        Route::post('home', [TransactionController::class, 'transactionList'])->name('api.home');
    });
});

Route::group(['prefix'=>'payment','middleware' => ['auth.token','check.admin']], function () {
    Route::post('/store/{id}', [PaymentController::class,'store'])->name('payment.store');
    Route::post('/list/{id}', [PaymentController::class,'create'])->name('payment.create');
});
Route::group(['prefix'=>'transaction','middleware' => ['auth.token','check.admin']], function () {
    Route::get('/users',[TransactionController::class,'create']);
    Route::post('/store', [TransactionController::class,'store'])->name('transaction.store');
});
Route::group(['prefix'=>'report','middleware' => ['auth.token','check.admin']], function () {
    Route::post('/', [ReportController::class,'generateMonthlyReport'])->name('report.get');
});
