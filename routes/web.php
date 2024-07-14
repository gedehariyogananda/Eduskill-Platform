<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseDetailController;
use App\Http\Controllers\CoursePrivatController;
use App\Http\Controllers\CourseUserController;
use App\Http\Controllers\StatisticController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'index')->name('login');
    Route::post('/', 'login')->name('loginPost');
    Route::get('/logout', 'logout')->name('logout');
});

Route::middleware('authenticated')->group(function () {
    // Dashboard Route
    Route::middleware('auth-roles:admin')->group(function () {
        Route::controller(StatisticController::class)->group(function () {
            Route::get('/statistic', 'index')->name('statistic');
        });

        Route::controller(CourseUserController::class)->name('datacourse.')->group(function () {
            Route::get('/course-users', 'index')->name('index');
        });

        Route::controller(CourseController::class)->name('course.')->group(function () {
            Route::get('/course', 'index')->name('index');
            Route::get('/course/create', 'create')->name('create');
            Route::post('/course', 'store')->name('store');
            Route::get('/course/{slug}/edit', 'edit')->name('edit');
            Route::patch('/course/{slug}', 'update')->name('update');
            Route::get('/course/archive/{slug}', 'archive')->name('archive');
            Route::get('/course/unarchive/{slug}', 'unarchive')->name('unarchive');
            Route::get('/course/archives/{slug}', 'archives')->name('archives');
            Route::get('course/recovery/{slug}', 'recovery')->name('recovery');
            // archive courses index
            Route::get('/data-courses/archives/show-data', 'indexArchived')->name('indexArchived');
        });

        Route::controller(CourseDetailController::class)->name('course.')->group(function () {
            Route::get('/data-courses/{slug}', 'show')->name('show');
            Route::get('/data-courses/{slug}/add-course', 'addCourses')->name('addCourses');
            Route::post('/data-courses/{slug}/add-course', 'storeCourses')->name('storeCources');
            Route::get('/data-courses/{slug}/edit', 'editCourses')->name('editCourses');
            Route::patch('/data-courses/{slug}/edit', 'updateCourses')->name('updateCourses');
            Route::get('/data-courses/{slug}/delete', 'destroyCourses')->name('destroyCourses');
        });

        Route::controller(CourseUserController::class)->name('course.')->group(function () {
            Route::get('/data-participans/{slug}', 'showParticipans')->name('showParticipans');
        });

        Route::controller(CoursePrivatController::class)->name('courseprivate.')->group(function () {
            Route::get('/data-courses-private', 'index')->name('index');
            Route::post('/data-courses-private/create', 'store')->name('store');
            Route::patch('/data-courses-private/{id}', 'update')->name('update');
            // destroy
            Route::get('/data-courses-private/{id}/deleted', 'destroy')->name('destroy');
        });
    });
});
