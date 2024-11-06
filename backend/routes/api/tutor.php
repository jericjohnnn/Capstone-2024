<?php

use App\Http\Controllers\TutorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/tutor-detail/{tutor_id}', [TutorController::class, 'showTutorDetail']);
    Route::get('/tutor-schedules/{tutor_id}', [TutorController::class, 'showTutorSchedules']);
    Route::get('/tutors', [TutorController::class, 'showTutors']);

    Route::post('/edit-details', [TutorController::class, 'editPersonalDetails']);
    Route::post('/add-school', [TutorController::class, 'createSchool']);
    Route::post('/add-certificate', [TutorController::class, 'createCertificate']);
    Route::put('/edit-certificate/{certificate_id}', [TutorController::class, 'editCertificate']);
    Route::put('/edit-school/{school_id}', [TutorController::class, 'editSchool']);
    Route::put('/edit-subjects', [TutorController::class, 'editSubjects']);
    Route::put('/edit-work-days', [TutorController::class, 'editWorkDays']);

    
    Route::patch('/test/{test_id}', [TutorController::class, '']); 

    Route::delete('/delete-school/{school_id}', [TutorController::class, 'deleteSchool']);
    Route::delete('/delete-certificate/{certificate_id}', [TutorController::class, 'deleteCertificate']);  
});
