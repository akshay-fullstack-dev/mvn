<?php

use Illuminate\Support\Facades\Route;
Route::namespace('IntersoftChat\App\Http\Controllers')->prefix('v1/chat')->middleware(['auth:api'])->group(function () {
  Route::post('send-message', 'ChatController@sendMessage');
  Route::get('inbox-listing', 'ChatController@inboxListing');
  Route::get('message-listing', 'ChatController@messageListing');
  Route::get('delete-chat', 'ChatController@deleteChat');
  Route::post('create-chat', 'ChatController@createChat');
});
