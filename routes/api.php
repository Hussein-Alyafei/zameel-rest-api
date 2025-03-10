<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\CollegeMajorsController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\GroupMajorController;
use App\Http\Controllers\MajorCollegeController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\MajorGroupsController;
use App\Http\Controllers\SubjectController;
use Illuminate\Support\Facades\Route;
use Orion\Facades\Orion;

Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/logout', [AuthenticationController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Orion::resource('colleges', CollegeController::class)->withSoftDeletes();
    Orion::hasManyResource('colleges', 'majors', CollegeMajorsController::class)->withSoftDeletes();

    Orion::resource('majors', MajorController::class)->withSoftDeletes();
    Orion::belongsToResource('majors', 'college', MajorCollegeController::class)->withSoftDeletes();
    Orion::hasManyResource('majors', 'groups', MajorGroupsController::class)->except(GroupController::EXCLUDE_METHODS);

    Orion::resource('subjects', SubjectController::class)->withSoftDeletes();

    Orion::resource('groups', GroupController::class)->except(GroupController::EXCLUDE_METHODS);
    Orion::belongsToResource('groups', 'major', GroupMajorController::class)->withSoftDeletes();
});
