<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{BoardingHouseController, BookingController, CategoryController, CityController, HomeController};

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/find-kos', [BoardingHouseController::class, 'find'])->name('find-kos');
Route::get('/find.results', [BoardingHouseController::class, 'findResults'])->name('find-kos.results');

Route::get('/kos/{slug}', [BoardingHouseController::class, 'show'])->name('kos.show');
Route::get('/kos/{slug}/rooms', [BoardingHouseController::class, 'rooms'])->name('kos.rooms');

Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');

Route::get('/city/{slug}', [CityController::class, 'show'])->name('city.show');

Route::get('/check-booking', [BookingController::class, 'check'])->name('check-booking');
