<?php

use App\Http\Controllers\Admin\Auth\UserController;
use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\LogoutController;
use App\Http\Controllers\Admin\AdminSubscriberController;
use App\Http\Controllers\Admin\AdminCommentController;
use App\Http\Controllers\Frontend\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AdminContactController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Frontend\GetPostController;
use App\Http\Controllers\Frontend\SubscriberController;
use App\Http\Controllers\Admin\SettingController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

   Route::prefix('admin/')->group(function () {

    Route::get('users', [UserController::class, 'admin'])->middleware('auth:sanctum');

      Route::post('register', [RegisterController::class, 'register']);
      Route::post('login', [LoginController::class, 'login']);
      Route::post('logout', [LogoutController::class, 'logout'])->middleware('auth:sanctum');

      //...catgeory controller...//

      Route::get('categories', [CategoryController::class, 'index']);
      Route::get('categories-total', [CategoryController::class, 'getTotalCategory']);
      Route::post('categories', [CategoryController::class, 'store']);
      Route::get('categories/{category}', [CategoryController::class, 'show']);
      Route::put('categories/{category}', [CategoryController::class, 'update']);
      Route::DELETE('categories/{category}', [CategoryController::class, 'destroy']);
      Route::get('search-categories/{search}', [CategoryController::class, 'search']);
  
   //...post controller...//

      Route::get('posts', [PostController::class, 'index']);
      Route::get('posts-total', [PostController::class, 'getTotalPost']);
      Route::post('posts', [PostController::class, 'store']);
      Route::get('posts/{post}', [PostController::class, 'show']);
      Route::put('posts/{post}', [PostController::class, 'update']);
      Route::DELETE('posts/{post}', [PostController::class, 'destroy']);
      Route::get('search-posts/{search}', [PostController::class, 'search']);
      
      //...settings..//
      Route::get('/settings/{setting}', [SettingController::class, 'index']);
      Route::post('/settings/{setting}', [SettingController::class, 'update']);

      //..contact..//
      Route::get('/contacts', [AdminContactController::class, 'index']);
      Route::delete('/contacts/{contact}', [AdminContactController::class, 'destroy']);

      //..subscriber..//
      Route::get('subscribers', [AdminSubscriberController::class, 'index']);
      Route::delete('subscribers/{subscriber}', [AdminSubscriberController::class, 'destroy']);

      //...comments..//
      Route::get('comments', [AdminCommentController::class, 'index']);
      Route::delete('comments/{comment}', [AdminCommentController::class, 'destroy']);

    });
   
      Route::prefix('front')->group(function () {
        Route::get('all-posts', [GetPostController::class, 'index']);
        Route::get('view-posts', [GetPostController::class, 'viewPosts']);
        Route::get('single-posts/{posts}', [GetPostController::class, 'getPostById']);

        Route::get('category-post/{id}', [GetPostController::class, 'getPostByCategory']);

        Route::get('search-posts/{search}', [GetPostController::class, 'searchPost']);
       
        Route::post('contacts', [ContactController::class, 'store']);

        Route::post('subscribers', [SubscriberController::class, 'store']);

        Route::get('comments', [CommentController::class, 'getComments']);
        Route::post('comments', [CommentController::class, 'store']);

      });