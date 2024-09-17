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
         Route::post('search', 'search')->name('posts.search');
         Route::post('/{post}/toggle-love', 'toggleLove')->name('posts.toggleLove');
      });

      //Comments
      Route::controller(CommentController::class)->group(function () {
         Route::post('{post}/comments', 'store')->name('comments.store');
         Route::get('comments/{comment}/edit', 'edit')->name('comments.edit');
         Route::delete('comments/{comment}', 'destroy')->name('comments.destroy');
         Route::put('comments/{comment}', 'update')->name('comments.update');
      });

      Route::controller(FriendRequestController::class)->group(function () {
         // Route::get('/', 'index')->name('friendRequests.index');
         Route::get('requests', 'requests')->name('friendRequests.requests');
          Route::post('/send', 'sendRequest')->name('friendRequests.send');
          Route::post('/accept', 'acceptRequest')->name('friendRequests.accept');   
          Route::delete('/decline/{id}', 'declineRequest')->name('friendRequests.decline');
          Route::delete('/cancel/{id}', 'cancelRequest')->name('friendRequests.cancel');
      });
   });
         
   // Friends
   Route::group(['prefix' => 'friends'], function () {
      Route::controller(FriendsController::class)->group(function () {
         Route::get('/', 'list')->name('friends.index');
         Route::get('friends/user/{userId}', 'showFriends')->name('friends.showUser');
         Route::delete('unfriend/{friendId}', 'unfriend')->name('friends.unfriend');
         Route::get('list', 'list')->name('friends.list');
         // Route::get('suggestions', 'suggestions')->name('friends.suggestions');
         // Route::delete('/remove-suggestion/{id}', 'removeSuggestion')->name('friends.removeSuggestion');x
         Route::get('search', 'search')->name('friends.search');
      });   
      // Route::controller(FriendRequestController::class)->group(function () {
      //    Route::get('suggestions', 'suggestions')->name('friends.suggestions');
      // });
   });

   // Friend Requests
   Route::group(['prefix' => 'friend-requests'], function () {
      Route::controller(FriendRequestController::class)->group(function () {
         Route::get('/', 'index')->name('friendRequests.index');
         Route::get('requests', 'requests')->name('friendRequests.requests');
          Route::post('/send', 'sendRequest')->name('friendRequests.send');
          Route::post('/accept', 'acceptRequest')->name('friendRequests.accept');   
          Route::delete('/decline/{id}', 'declineRequest')->name('friendRequests.decline');
          Route::delete('/cancel/{id}', 'cancelRequest')->name('friendRequests.cancel');
          Route::get('suggestions', 'suggestions')->name('friendRequests.suggestions');

      });
   });

   // Profile 
   Route::group(['prefix'=> 'profile'], function () {
      Route::controller(ProfileController::class)->group(function() {
         Route::get('/', 'index')->name('profile.index');
         Route::get('/{id}', 'show')->name('profile.show'); 
         Route::get('/edit', 'edit')->name('profile.edit');
         Route::put('/update', 'update')->name('profile.update');
      });

      Route::controller(FriendsController::class)->group(function() {
         Route::delete('unfriend/{friendId}', 'unfriend')->name('friends.unfriend');
      });

      Route::controller(FriendRequestController::class)->group(function() {
         Route::post('/send', 'sendRequest')->name('friendRequests.send');
         Route::delete('/cancel{id}', 'cancelRequest')->name('friendRequests.cancel');
         Route::post('/accept', 'acceptRequest')->name('friendRequests.accept');   
          Route::delete('/decline/{id}', 'declineRequest')->name('friendRequests.decline');
      });
   });
});

