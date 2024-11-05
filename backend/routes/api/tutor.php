<?php

use App\Http\Controllers\TutorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/tutor-detail/{tutor_id}', [TutorController::class, 'showTutorDetail']);
    Route::get('/tutor-schedules/{tutor_id}', [TutorController::class, 'showTutorSchedules']);
    Route::get('/tutors', [TutorController::class, 'showTutors']);

    Route::put('/edit-subjects', [TutorController::class, 'editSubjects']);

    Route::patch('/test/{test_id}', [TutorController::class, '']); // Specify method here
    Route::delete('/test/{test}', [TutorController::class, '']);  // Specify method here
});
