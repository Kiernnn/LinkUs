<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FriendsController;
use App\Http\Controllers\CreateController;
use App\Http\Controllers\ProfileController;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/friends', [FriendsController::class, 'index'])->name('friends.index');
Route::get('/create', [CreateController::class, 'index'])->name('create.index');
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');

Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

