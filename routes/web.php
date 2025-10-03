<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PizzaController;
use App\Http\Controllers\winkelwagentjeController;
use App\Http\Controllers\HomeController;

Route::get('/menu', [PizzaController::class, 'index'])->name('menu');
Route::get('/home', [HomeController::class, 'index']) ->name('home');
   


Route::get('/order/{pizza}', [App\Http\Controllers\WinkelwagentjeController::class, 'quickOrderForm'])->name('quickOrder.form');
Route::post('/order/{pizza}', [App\Http\Controllers\WinkelwagentjeController::class, 'quickOrderStore'])->name('quickOrder.store');
Route::get('/winkelwagentje', [WinkelwagentjeController::class, 'index'])->name('winkelwagentje.index');
Route::post('/winkelwagentje', [WinkelwagentjeController::class, 'store'])->name('winkelwagentje.store');
Route::post('/winkelwagentje/remove', [WinkelwagentjeController::class, 'remove'])->name('winkelwagentje.remove');
Route::post('/winkelwagentje/increment', [WinkelwagentjeController::class, 'increment'])->name('winkelwagentje.increment');
Route::patch('/winkelwagentje/decrement', [WinkelwagentjeController::class, 'decrement'])->name('winkelwagentje.decrement');
Route::post('/winkelwagentje/betaal', [WinkelwagentjeController::class, 'betaal'])->name('bestelling.betaal');



