<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\JobSeekerController;
use App\Http\Controllers\ProfileController;
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

    Route::controller(ProfileController::class)->group(function(){
        Route::get('/profile', 'profile');
        Route::patch('/change-email', 'changeEmail');
        Route::patch('/change-password','changePassword');
        Route::patch('/change-profile-picture', 'changeProfilePicture');
    });
    Route::get('/applied-jobs', [JobSeekerController::class,'appliedJobs'])->middleware('role:user');
    Route::controller(AdminController::class)->prefix('/admin')->group(function(){
        Route::get('/pending-jobs','pendingJobs')->middleware('role:admin');
        Route::put('/approve-job/{id}','approveJob')->middleware('role:admin');
    });
});

Route::prefix('job')->group(function(){
    Route::get('/list',[JobPostController::class,'list']);
    Route::get('/retrieve/{id}',[JobPostController::class,'retrieve']);
});
