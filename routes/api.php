<?php

use App\Http\Controllers\AdoptionController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


/* Guides */
Route::resource('post', PostController::class);
Route::get('posts', [PostController::class, 'get']);
Route::post('posts', [PostController::class, 'store']);
Route::put('posts', [PostController::class, 'update']);
Route::delete('posts', [PostController::class, 'destroy']);

/* Adoption */
Route::resource('adoption', AdoptionController::class);
Route::get('adoption', [AdoptionController::class, 'get']);
Route::post('adoption', [AdoptionController::class, 'store']);
Route::put('adoption', [AdoptionController::class, 'update']);
Route::delete('adoption', [AdoptionController::class, 'destroy']);


/* Login */
Route::middleware(['auth:sanctum'])->group(function(){
    
    Route::post('/logout', [UserAuthController::class, 'logout']);
    Route::get('/loggeduser', [UserAuthController::class, 'logged_user']);
    Route::post('/changepassword', [UserAuthController::class, 'change_password']);
});
Route::prefix('api')->group(function () {
    Route::post('/login', [UserAuthController::class, 'login']);
    Route::post('/admin/login', [AdminAuthController::class, 'apiLogin']);
    // Protected routes
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });
});