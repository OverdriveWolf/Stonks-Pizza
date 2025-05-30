<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PizzaController;
use App\Http\Controllers\winkelwagentjeController;
use App\Http\Controllers\BestellingController;

Route::get('/menu', [PizzaController::class, 'index'])->name('menu');
route::get('/home', function () {
    return view('home');
})->name('home');


Route::get('/winkelwagentje', [winkelwagentjeController::class, 'index'])->name('winkelwagentje.index');
Route::post('/winkelwagentje', [winkelwagentjeController::class, 'store'])->name('winkelwagentje.store');
Route::post('/winkelwagentje/remove', [winkelwagentjeController::class, 'remove'])->name('winkelwagentje.remove');
Route::post('/winkelwagentje/betaal', [WinkelwagentjeController::class, 'betaal'])->name('bestelling.betaal');
Route::post('/winkelwagentje/annuleer', [Winkelwagentjecontroller::class, 'annuleer'])->name('bestelling.annuleer');



