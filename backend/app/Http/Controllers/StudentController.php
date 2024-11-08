<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\EditStudentDetailsRequest;
use App\Http\Requests\Tutor\EditPersonalDetailsRequest;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    //NORMAL USER METHODS INSERT HERE
    public function createStudent($validatedDataWithUserId)
    {
        $student = Student::create($validatedDataWithUserId);
        return $student;
    }

    public function deleteStudentAccount()
    {
        $user = Auth::user();

        User::destroy($user->id);
        return response()->json(['message' => 'Student deleted successfully.']);
    }


    public function getStudentDetails()
    {
        $user = Auth::user();
        $studentId = $user->student->id;

        $student = Student::where('id', $studentId)->first();

        return response()->json([
            'message' => 'Student retrieved successfully.',
            'student' => $student,
        ]);
    }

    public function editPersonalDetails(EditStudentDetailsRequest $request)
    {
        $validatedData = $request->validated();

        $user = Auth::user();
        $student = $user->student;

        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            $validatedData['profile_image'] = asset('storage/' . $imagePath);
        }

        $student->update($validatedData);

        return response()->json([
            'message' => 'Student updated successfully.',
            'student' => $student,
        ]);
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
