<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobPostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/register',[AuthController::class,'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){
    Route::post('logout',[AuthController::class, 'logout']);

    Route::controller(JobPostController::class)->prefix('job-post')->group(function(){
        Route::post('/create','create')->middleware('role:employer');
        Route::put('/update/{id}','update')->middleware('role:employer');
        Route::delete('delete/{id}','delete')->middleware('role:employer,admin');
    });

    Route::controller(ApplicationController::class)->prefix('application')->group(function(){
        Route::post('/create','create')->middleware('role:user');
        Route::get('/list/{id}','list')->middleware('role:employer');
        Route::get('/retrieve/{id}', 'retrieve')->middleware('role:employer');
    });
});

Route::prefix('job-post')->group(function(){
    Route::get('/list',[JobPostController::class,'list']);
    Route::get('/retrieve/{id}',[JobPostController::class,'retrieve']);
});
