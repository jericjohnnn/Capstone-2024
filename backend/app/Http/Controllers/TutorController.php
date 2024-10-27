<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ApprovalStatusRequest;
use App\Http\Requests\Admin\ContactedStatusRequest;
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

    public function showTutors(Request $request)
    {
        // Fetch tutors with pagination (4 items per page)
        $tutors = Tutor::with('subjects:id,name', 'ratings:id,tutor_id,rate')
            ->paginate(4);

        // Use 'through()' to transform each item while keeping pagination intact
        $tutors->through(function ($tutor) {
            return [
                'id' => $tutor->id,
                'tutor_name' => "{$tutor->first_name} {$tutor->last_name}",
                'profile_image' => $tutor->profile_image,
                'tutor_subjects' => $tutor->subjects->pluck('name'),
                'tutor_rating' => $tutor->ratings->avg('rate'),
            ];
        });

        // Return the paginated data with metadata
        return response()->json([
            'message' => 'Tutors retrieved successfully.',
            'tutor_previews' => $tutors, // Includes paginated data and metadata
        ]);
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

    public function changeContactedStatus(Request $request, $tutor_id)
    {
        $tutor = Tutor::findOrFail($tutor_id);

        $tutor->contacted_status = $request['contacted_status'];
        $tutor->save();

        return response()->json(['message' => 'Contacted status updated successfully.']);
    }
}
