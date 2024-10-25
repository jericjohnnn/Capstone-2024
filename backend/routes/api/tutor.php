<?php

use App\Http\Controllers\TutorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/tutors', [TutorController::class, 'showTutors']);

Route::post('/test', [TutorController::class, '']);

Route::patch('/test/{test_id}', [TutorController::class, '']);

Route::delete('/test/{test}', [TutorController::class, '']);
