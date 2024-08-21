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
   Route::group(['prefix' => 'friends'], function () {
      Route::controller(FriendsController::class)->group(function () {
          Route::get('/', 'index')->name('friends.index');
          Route::post('/unfriend/{friendId}', 'unfriend')->name('friends.unfriend');
      });
  });

  // Friend Requests Routes
  Route::group(['prefix' => 'friend-requests'], function () {
      Route::controller(FriendRequestController::class)->group(function () {
          Route::get('/', 'index')->name('friendRequests.index');
          Route::post('/send/{receiverId}', 'sendRequest')->name('friendRequests.sendRequest');
          Route::post('/accept/{requestId}', 'acceptRequest')->name('friendRequests.acceptRequest');
          Route::post('/decline/{requestId}', 'declineRequest')->name('friendRequests.declineRequest');
          Route::delete('/cancel/{requestId}', 'cancelRequest')->name('friendRequests.cancelRequest');
      });
  });


   // Profile 
   Route::group(['prefix'=> 'profile'], function () {
      Route::controller(ProfileController::class)->group(function() {
         Route::get('/', 'index')->name('profile.index');
         Route::get('edit', 'edit')->name('profile.edit');
         Route::put('update', 'update')->name('profile.update');
      });
   });
});

