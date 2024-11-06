<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    //NORMAL USER METHODS INSERT HERE
    public function createStudent($validatedDataWithUserId)
    {
        $student = Student::create($validatedDataWithUserId);
        return $student;
    }







    //ADMIN METHODS INSERT HERE
    public function showAllStudents()
    {
        $students = Student::all();

        return response()->json([
            'message' => 'Students retrieved successfully.',
            'all_students' => $students,
        ]);
    }

}
