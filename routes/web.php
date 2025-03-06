<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});
Route::prefix("products")->group(function(){
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/show/{id}', [ProductController::class, 'show']);
    Route::post('/', [ProductController::class, 'store'])->name('products.store');
    Route::put('/update/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/delete/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/form/{id?}', [ProductController::class, 'getForm']);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
