<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//AUTH CONTROLLER ROUTES
Route::post('admin/login', [AuthController::class, 'adminLogin']);

//USER CONTROLLER ROUTES
Route::delete('admin/delete-user', [UserController::class, 'deleteUser']);
Route::patch('admin/offense-status', [UserController::class, 'changeOffenseStatus']);

//TUTOR CONTROLLER ROUTES
Route::get('admin/all-tutors', [TutorController::class, 'showAllTutors']);
Route::get('admin/accepted-tutors', [TutorController::class, 'showAcceptedTutors']);
Route::patch('admin/approval-status', [TutorController::class, 'changeApprovalStatus']);

//STUDENT CONTROLLER ROUTES
Route::get('admin/all-students', [StudentController::class, 'showAllStudents']);

//REPORT CONTROLLER ROUTS
Route::get('admin/all-reports', [ReportController::class, 'showAllReports']);
Route::get('admin/{report_id}', [ReportController::class, 'showReport']);
Route::patch('admin/report-status', [ReportController::class, 'changeReportStatus']);