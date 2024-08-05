<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FriendsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommentController;


Auth::routes();

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth']], function () {

   Route::get('/', [PostController::class, 'index'])->name('posts.index'); //default route

   //posts
   Route::group(['prefix'=> 'posts'], function () {
      Route::controller(PostController::class)->group(function () {
         Route::get('create', 'create')->name('posts.create');
         Route::post('store', 'store')->name('posts.store');
         Route::get('edit', 'edit')->name('posts.edit');
         Route::delete('{post}','delete')->name('posts.delete');
         Route::get('detail','detail')->name('posts.detail');
      });
   });

   Route::group(['prefix'=> 'comments'], function () {
      Route::controller(CommentController::class)->group(function () {
         Route::post('add', 'create')->name('comments.detail');
         Route::get('delete/{id}', 'delete')->name('comments.delete');
      });
   });
});


Route::get('/friends', [FriendsController::class, 'index'])->name('friends.index');

Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');



