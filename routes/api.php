<?php


use App\Http\Controllers\api\AdoptionApplicationController;
use App\Http\Controllers\api\AdoptionController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\PostController;
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


/* User */
Route::get('/user', [UserAuthController::class,'user']);
Route::post('/register', [UserAuthController::class,'add']);
Route::put('/update/{id}', [UserAuthController::class,'update']);
Route::delete('/user/{id}', [UserAuthController::class,'delete']);

/* User Authentication */
Route::post('/login', [UserAuthController::class, 'login']);
Route::post('/logout', [UserAuthController::class, 'logout'])->middleware('auth:sanctum');



// Post Adoption
Route::get('/adoptions', [AdoptionController::class, 'get']);
Route::post('/adoptions', [AdoptionController::class, 'store'])->middleware('auth:sanctum');
Route::get('/adoptions/{id}', [AdoptionController::class, 'show']);
Route::put('/adoptions/{id}', [AdoptionController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/adoptions/{id}', [AdoptionController::class, 'destroy'])->middleware('auth:sanctum');
Route::get('/adoptions/{adoptionId}/applications', [AdoptionController::class, 'viewApplications'])->middleware('auth:sanctum');

// Application
Route::get('/adoptions/{adoptionId}/application', [AdoptionApplicationController::class, 'showApplicationForm'])->name('adoptions.application.show');
Route::post('/adoptions/{adoptionId}/apply', [AdoptionApplicationController::class, 'submitApplication'])->middleware('auth:sanctum');
Route::post('/applications/{applicationId}/accept', [AdoptionApplicationController::class, 'acceptApplication'])->middleware('auth:sanctum');
Route::delete('/applications/{applicationId}', [AdoptionApplicationController::class, 'rejectApplication'])->name('applications.reject');

