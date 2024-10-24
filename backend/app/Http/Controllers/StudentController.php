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
        Student::create([
            'user_id' => $validatedDataWithUserId['user_id'],
            'first_name' => $validatedDataWithUserId['first_name'],
            'last_name' => $validatedDataWithUserId['last_name'],
            'address' => $validatedDataWithUserId['address'],
            'birthdate' => $validatedDataWithUserId['birthdate'],
            'contact_number' => $validatedDataWithUserId['contact_number'],
        ]);
        return [
            'message' => 'Student successfully created',
        ];
    }


    //ADMIN METHODS INSERT HERE
    public function showAllStudents(Request $request)
    {
        $students = Student::paginate(10);

        return response()->json([
            'message' => 'Students retrieved successfully.',
            'all_students' => $students,
        ]);
    }

}
