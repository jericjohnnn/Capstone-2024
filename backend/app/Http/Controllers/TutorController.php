<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ApprovalStatusRequest;
use App\Models\Tutor;
use Illuminate\Http\Request;

class TutorController extends Controller
{
    //NORMAL USER METHODS INSERT HERE
    public function createTutor($validatedDataWithUserId)
    {
        Tutor::create([
            'user_id' => $validatedDataWithUserId['user_id'],
            'first_name' => $validatedDataWithUserId['first_name'],
            'last_name' => $validatedDataWithUserId['last_name'],
            'address' => $validatedDataWithUserId['address'],
            'birthdate' => $validatedDataWithUserId['birthdate'],
            'gender' => $validatedDataWithUserId['gender'],
            'contact_number' => $validatedDataWithUserId['contact_number'],
            'tutor_rate' => $validatedDataWithUserId['tutor_rate'],
            'school_id_number' => $validatedDataWithUserId['school_id_number'],
            'course' => $validatedDataWithUserId['course'],
            'year' => $validatedDataWithUserId['year'],
        ]);
        return [
            'message' => 'Tutor successfully created',
        ];
    }




    //ADMIN METHODS INSERT HERE
    public function showAllTutors(Request $request)
    {
        // Retrieve all tutors
        $tutors = Tutor::paginate(10);

        return response()->json([
            'message' => 'Tutors retrieved successfully.',
            'all_tutors' => $tutors,
        ]);
    }

    public function showAcceptedTutors(Request $request)
    {
        $acceptedTutors = Tutor::where('approval_status', 'Accepted')->paginate(10);

        return response()->json([
            'message' => 'Accepted tutors retrieved successfully.',
            'accepted_tutors' => $acceptedTutors,
        ]);
    }

    public function changeApprovalStatus(ApprovalStatusRequest $request, $tutor_id)
    {
        $validatedData = $request->validated();

        $tutor = Tutor::findOrFail($tutor_id);

        $tutor->approval_status = $validatedData['approval_status'];
        $tutor->save();

        return response()->json(['message' => 'Approval status updated successfully.']);
    }
}
