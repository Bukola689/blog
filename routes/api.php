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
use App\Http\Controllers\Admin\AdminPermissionController;
use App\Http\Controllers\Admin\AdminRoleController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Frontend\GetPostController;
use App\Http\Controllers\Frontend\SubscriberController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\V1\Admin\VerifyEmailController;
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

    Route::group(['v1'], function() {

      Route::get('all-posts', [GetPostController::class, 'index']);
      Route::get('view-posts', [GetPostController::class, 'viewPosts']);
      Route::get('single-posts/{posts}', [GetPostController::class, 'getPostById']);

      Route::get('category-post/{id}', [GetPostController::class, 'getPostByCategory']);

      Route::get('search-posts/{search}', [GetPostController::class, 'searchPost']);
     
      Route::post('contacts', [ContactController::class, 'store']);

      Route::post('subscribers', [SubscriberController::class, 'store']);

      Route::get('comments', [CommentController::class, 'getComments']);
      Route::post('comments', [CommentController::class, 'store']);


           //....auth....//
       Route::group(['prefix'=> 'auth'], function() {
          Route::post('register', [RegisterController::class, 'register']);
          Route::post('login', [LoginController::class, 'login']);
          Route::post('forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
       Route::group(['middleware' => 'auth:sanctum'], function() {
          Route::post('logout', [LogoutController::class, 'logout']);
          Route::post('/email/verification-notification', [VerifyEmailController::class, 'resendNotification'])->name('verification.send');
          Route::post('reset-password', [ResetPasswordController::class, 'resetPassword']); 

          });
     });

          Route::group(['middleware' => 'me', 'middleware' => 'auth:sanctum'], function() {
 
            Route::post('/profiles', [ProfileController::class, 'updateProfile']);
            Route::post('/change-password', [ProfileController::class, 'changePassword']);

           });

           Route::group(['middleware' => ['role:admin'], 'prefix' => 'admin'], function () {

              Route::get('users', [UserController::class, 'admin']);
              Route::get('users', [UserController::class, 'index']);
              Route::post('users', [UserController::class, 'store']);
              Route::get('users/{id}', [UserController::class, 'show']);
              Route::put('users/{id}', [UserController::class, 'update']);
              Route::delete('users/{id}', [UserController::class, 'destroy']);
              Route::post('users/{id}/suspend', [UserController::class, 'suspend']);
              Route::post('users/{id}/active', [UserController::class, 'active']);
              Route::get('users/{id}/roles', [AdminRoleController::class, 'show']);
              Route::get('users/{id}/permissions', [AdminPermissionController::class, 'show']);
              Route::post('users/{id}/roles', [AdminRoleController::class, 'changeRole']);

          //...catgeory controller...//

            Route::get('categories', [CategoryController::class, 'index']);
            Route::get('categories-total', [CategoryController::class, 'getTotalCategory']);
            Route::post('categories', [CategoryController::class, 'store']);
            Route::get('categories/{id}', [CategoryController::class, 'show']);
            Route::put('categories/{id}', [CategoryController::class, 'update']);
            Route::DELETE('categories/{id}', [CategoryController::class, 'destroy']);
            Route::get('search-categories/{search}', [CategoryController::class, 'search']);
  
   //...post controller...//

           Route::get('posts', [PostController::class, 'index']);
           Route::get('posts', [PostController::class, 'getPostByCategory']);
           Route::post('posts', [PostController::class, 'store']);
           Route::get('posts/{id}', [PostController::class, 'show']);
           Route::put('posts/{id}', [PostController::class, 'update']);
           Route::DELETE('posts/{id}', [PostController::class, 'destroy']);
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

  });
   
      