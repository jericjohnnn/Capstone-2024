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
        $tutor = Tutor::create($validatedDataWithUserId);
        return $tutor;
    }

    public function showTutors()
    {
        $tutors = Tutor::with('subjects:id,name', 'ratings:id,tutor_id,rate')
            ->paginate(4);

        // ignore lang ning red sa "through" kay wa pako kita
        // sa extension nga modetect na siya, kay bag o na nga feature sa laravel
        $tutors->through(function ($tutor) {
            return [
                'id' => $tutor->id,
                'tutor_name' => "{$tutor->first_name} {$tutor->last_name}",
                'profile_image' => $tutor->profile_image,
                'tutor_subjects' => $tutor->subjects->pluck('name'),
                'tutor_rating' => $tutor->ratings->avg('rate'),
            ];
        });

        return response()->json([
            'message' => 'Tutors retrieved successfully.',
            'tutor_previews' => $tutors,
        ]);
    }

    public function showTutorDetail($tutor_id)
    {
        $tutor = Tutor::where('id', $tutor_id)
            ->with('workDays', 'schools', 'certificates', 'subjects', 'ratings.student:id,first_name,last_name,profile_image')
            ->first();

        return response()->json([
            'message' => 'Tutor retrieved successfully.',
            'tutor' => $tutor,
        ]);
    }










    //ADMIN METHODS INSERT HERE
    public function showAllTutors()
    {
        $tutors = Tutor::paginate(8);

        return response()->json([
            'message' => 'Tutors retrieved successfully.',
            'all_tutors' => $tutors,
        ]);
    }

    public function showAcceptedTutors()
    {
        $acceptedTutors = Tutor::where('approval_status', 'Accepted')->paginate(8);

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
