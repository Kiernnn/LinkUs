<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FriendsController;
use App\Http\Controllers\ProfileController;


Auth::routes();

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

//posts
Route::get('/', [PostController::class, 'index'])->name('posts.index');

Route::group(['prefix'=> 'posts'], function () {
   Route::controller(PostController::class)->group(function () {
      Route::get('create', 'create')->name('posts.create');
      Route::post('store', 'store')->name('posts.store');
   });
});

Route::get('/friends', [FriendsController::class, 'index'])->name('friends.index');

Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');

// Route::middleware('web')->group(function () {
//    Route::post('/logout', function () {
//        Auth::logout();
//        return redirect('/');
//    })->name('logout');
// });



