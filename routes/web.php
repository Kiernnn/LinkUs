<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FriendsController;
use App\Http\Controllers\ProfileController;

Auth::routes();

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth']], function () {

   Route::get('/', [PostController::class, 'index'])->name('posts.index'); //default route

   //posts
   Route::group(['prefix'=> 'posts'], function () {
      Route::controller(PostController::class)->group(function () {
         Route::get('create', 'create')->name('posts.create');
         Route::post('store', 'store')->name('posts.store');
         Route::get('edit/{post}', 'edit')->name('posts.edit');
         Route::post('{post}/love', 'love')->name('posts.love');
         Route::put('update/{post}', 'update')->name('posts.update');
         Route::delete('{post}','destroy')->name('posts.destroy');
         Route::get('{post}','detail')->name('posts.detail');
      });

      //Comments
      Route::controller(CommentController::class)->group(function () {
         Route::post('{post}/comments', 'store')->name('comments.store');
         Route::get('comments/{comment}/edit', 'edit')->name('comments.edit');
         Route::delete('comments/{comment}', 'destroy')->name('comments.destroy');
         Route::put('comments/{comment}', 'update')->name('comments.update');
      });
   });

   // Friends Routes
   Route::group(['prefix'=> 'friends'], function() {
      Route::controller(FriendsController::class)->group(function() {
         Route::get('/', 'index')->name('friends.index');
         Route::post('/send-request/{receiverId}', 'sendRequest')->name('friends.sendRequest');
         Route::post('/accept-request/{requestId}', 'acceptRequest')->name('friends.acceptRequest');
         Route::post('/decline-request/{requestId}', 'declineRequest')->name('friends.declineRequest');
         Route::post('/unfriend/{friendId}', 'unfriend')->name('friends.unfriend');
      });
   });

   // Profile Routes
   Route::group(['prefix'=> 'profile'], function () {
      Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
      Route::get('edit', [ProfileController::class, 'edit'])->name('profile.edit');
      Route::put('update', [ProfileController::class, 'update'])->name('profile.update');
   });
});

