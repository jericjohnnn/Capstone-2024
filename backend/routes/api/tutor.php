<?php

use App\Http\Controllers\TutorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/tutor-detail/{tutor_id}', [TutorController::class, 'showTutorDetail']);
Route::get('/tutor-schedules/{tutor_id}', [TutorController::class, 'showTutorSchedules']);
Route::get('/tutors', [TutorController::class, 'showTutors']);

Route::post('/test', [TutorController::class, '']);

Route::patch('/test/{test_id}', [TutorController::class, '']);

Route::delete('/test/{test}', [TutorController::class, '']);
