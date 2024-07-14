<?php

use App\Http\Controllers\API\Auth\AuthenticateController;
use App\Http\Controllers\Api\CourseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// authenticate
Route::controller(AuthenticateController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('verify/otp', 'verifyOtp');
    Route::post('verify/otp/newotp', 'newOtp');
    Route::post('forgot', 'forgot');
    Route::post('reset', 'reset');
    Route::post('logout', 'logout');
});

Route::controller(CourseController::class)->group(function () {
    Route::get('online-course', 'onlineCourse');
    Route::get('all/online-course', 'allOnlineCourse');
    Route::get('course/{slug}', 'courseSpesify');
    Route::get('privat-course', 'privatCourse');
    Route::get('all/privat-course', 'allPrivatCourse');
    Route::post('buy/course/{course}', 'buyCourse');
    Route::post('buy/course/privat/{course}/{idPacket}', 'buyCoursePrivat');
    Route::get('courses/user', 'courseUser');

    // callback notif webhook
    Route::post('callback/notif', 'callbackNotif');
});
