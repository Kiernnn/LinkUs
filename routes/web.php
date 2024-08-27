<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FriendsController;
use App\Http\Controllers\FriendRequestController;
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
         
   // Friends
   Route::group(['prefix' => 'friends'], function () {
      Route::controller(FriendsController::class)->group(function () {
         Route::get('/', 'index')->name('friends.index');
         Route::get('requests', 'requests')->name('friends.requests');
         Route::delete('unfriend', 'unfriend')->name('friends.unfriend');
         Route::get('suggestions', 'suggestions')->name('friends.suggestions');
         Route::delete('/remove-suggestion/{id}', 'removeSuggestion')->name('friends.removeSuggestion');
         Route::get('search', 'search')->name('friends.search');
      });
   });

   // Friend Requests
   Route::group(['prefix' => 'friend-requests'], function () {
      Route::controller(FriendRequestController::class)->group(function () {
         Route::get('/', 'index')->name('friendRequests.index');
          Route::post('/send/{receiverId}', 'sendRequest')->name('friendRequests.send');
          Route::post('/accept/{id}', 'acceptRequest')->name('friendRequests.accept');
          Route::delete('/decline/{id}', 'declineRequest')->name('friendRequests.decline');
          Route::delete('/cancel/{id}', 'cancelRequest')->name('friendRequests.cancel');
          Route::delete('/remove-suggestion/{id}', 'removeSuggestion')->name('friendRequests.removeSuggestion');
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

