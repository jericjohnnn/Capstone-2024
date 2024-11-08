<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/edit-student-details', [StudentController::class, 'editPersonalDetails']);
    Route::delete('/delete-student-account', [StudentController::class, 'deleteStudentAccount']);
    Route::get('/student-info', [StudentController::class, 'getStudentDetails']);
});


