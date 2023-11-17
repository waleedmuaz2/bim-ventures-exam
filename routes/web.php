<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::get('/home', [TransactionController::class, 'transactionList'])->middleware('auth')->name('home');

Route::group(['prefix'=>'payment','middleware' => ['auth','check.admin']],function (){
    Route::get('/{id}', [PaymentController::class,'create'])->name('payment..create');
    Route::post('/create/{id}', [PaymentController::class,'store'])->name('payment..store');
});

Route::group(['prefix'=>'transaction','middleware' => ['auth','check.admin']],function (){
    Route::get('/', [TransactionController::class,'create'])->name('transaction..create');
    Route::post('/create', [TransactionController::class,'store'])->name('transaction..store');
});

Route::group(['prefix'=>'report','middleware' => ['auth','check.admin']],function(){
    Route::post('/submit', [ReportController::class,'generateMonthlyReport'])->name('report..submit');
});
