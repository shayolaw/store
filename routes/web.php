<?php

use App\Http\Controllers\OrdersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('welcome');
});
Route::prefix("products",)->middleware('auth')->group(function(){
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/show/{id}', [ProductController::class, 'show']);
    Route::post('/', [ProductController::class, 'store'])->name('products.store');
    Route::put('/update/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/delete/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/form/{id?}', [ProductController::class, 'getForm']);
})->middleware('auth');
Route::prefix('orders')->middleware("auth")->group(function(){
    Route::get('/charge',[OrdersController::class,'charge']);
    Route::get('/',[OrdersController::class,'index']);
    Route::post('/',[OrdersController::class,'create'])->name('products.save');
    Route::put('/{id}',[OrdersController::class,'update'])->name('products.update');
    Route::get('/{id}',[OrdersController::class,'show'])->name('products.show');
    Route::delete('/delete/{id}',[OrdersController::class,'delete'])->name('products.delete');
});
Route::post('/api/login',[LoginController::class,"authenticate"]);
Route::get('/failed',[OrdersController::class,'failed']);
Route::get('/success',[OrdersController::class,'success']);
Route::post('/api/approve_payment',[OrdersController::class,'handleWebhook']);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
