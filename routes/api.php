<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->group(function() {
  // Route::get('/user', function (Request $request) {
  //   return $request->user();
  // });

  // Route::post('/posts', 'PostsController@store');
  // Route::get('/posts', 'PostsController@index');
  Route::get('auth-user', 'AuthUserController@show');

  Route::apiResources([
    'posts' => 'PostsController',
    'users' => 'UsersController',
    '/users/{user}/posts' => 'UserPostsController',
    'friend-request' => 'FriendRequestsController',
  ]);

  // Route::get('/users/:userId', 'UsersController@show');
});
