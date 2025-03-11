<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\CollegeMajorController;
use App\Http\Controllers\MajorCollegeController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\SubjectController;
use Illuminate\Support\Facades\Route;
use Orion\Facades\Orion;

Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/logout', [AuthenticationController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Orion::resource('colleges', CollegeController::class)->withSoftDeletes();
    Orion::hasManyResource('colleges', 'majors', CollegeMajorController::class)->withSoftDeletes();

    Orion::resource('majors', MajorController::class)->withSoftDeletes();
    Orion::belongsToResource('majors', 'college', MajorCollegeController::class)->withSoftDeletes();

    Orion::resource('subjects', SubjectController::class)->withSoftDeletes();

    Route::post('verify-email', VerifyEmailController::class)
        ->middleware(['throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', EmailVerificationNotificationController::class)
        ->middleware('throttle:6,1')
        ->name('verification.send');
});

Route::post('forgot-password', PasswordResetLinkController::class)
    ->name('password.email');

Route::post('reset-password', NewPasswordController::class)
    ->name('password.store');
