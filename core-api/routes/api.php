<?php
  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
  
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\NewPasswordController;
use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\LikeController;
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
  //login and register api routes//
Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);

//forgot and reset password endpoint//
Route::post('forgot-password', [NewPasswordController::class, 'forgotPassword']);
Route::post('reset-password', [NewPasswordController::class, 'reset']);


// Route::post('attachmenttype', [PostController::class, 'store']);
// Route::post('profilepicture', [RegisterController::class, 'profilepicture']);
// Route::post('CommentNotification', [CommentController::class, 'CommentNotifications']);
// Route::post('LikeNotification', [LikeController::class, 'LikeNotifications']);


//create,update and delete a post apis endpoint//
Route::group(['middleware'=>['auth:api']], function(){
    Route::get('authuser',  [RegisterController::class, 'authuser']);
    Route::get('get-profile', [RegisterController::class, 'getProfile']);
    Route::post('update-profile', [RegisterController::class, 'updateProfile']);
    Route::resource('posts', PostController::class);
    Route::post('comment', [CommentController::class, 'store']);
    Route::post('like', [LikeController::class, 'like']);
    Route::post('dislike', [LikeController::class, 'dislike']);
    Route::get('logout',  [RegisterController::class, 'logout']);
});

