<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PizzaController;
use App\Http\Controllers\winkelwagentjeController;
use App\Http\Controllers\HomeController;

Route::get('/menu', [PizzaController::class, 'index'])->name('menu');
Route::get('/home', [HomeController::class, 'index']) ->name('home');
   



Route::get('/winkelwagentje', [WinkelwagentjeController::class, 'index'])->name('winkelwagentje.index');
Route::post('/winkelwagentje', [WinkelwagentjeController::class, 'store'])->name('winkelwagentje.store');
Route::post('/winkelwagentje/remove', [WinkelwagentjeController::class, 'remove'])->name('winkelwagentje.remove');
Route::post('/winkelwagentje/betaal', [WinkelwagentjeController::class, 'betaal'])->name('bestelling.betaal');
Route::post('/winkelwagentje/annuleer', [WinkelwagentjeController::class, 'annuleer'])->name('bestelling.annuleer');



