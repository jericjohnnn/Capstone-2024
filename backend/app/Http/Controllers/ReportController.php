<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Tutor;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    //NORMAL USER METHODS INSERT HERE







    //ADMIN METHODS INSERT HERE
    public function showAllReports(Request $request)
    {
        // $userType = UserType::where('id', 'Accepted')->all();
        // $users = User::with('userType')->get();
        // $userTypes = $users->pluck('userType.type');

        // $types = $users->map(function($user) {
        //     return $user->userType->type;
        // });

        // Retrieve reports with their complainants
        $reports = Report::with('complainant')->get();

        // Extract complainant IDs from reports without making them unique
        $complainant_ids = $reports->pluck('complainant_id');

        // Fetch tutors whose user IDs are in the complainant IDs
        $tutors = Tutor::whereIn('user_id', $complainant_ids)
            ->select('id', 'first_name')
            ->get();

        // Extract first names of the tutors
        $tutor_names = $tutors->pluck('first_name');

        return response()->json([
            'message' => 'Accepted tutors retrieved successfully.',
            'tutor_names' => $tutor_names,
        ]);
    }

    public function showReport(Request $request)
    {
        //
        return response()->json(['message' => '']);
    }

    public function changeReportStatus(Request $request)
    {
        //
        return response()->json(['message' => '']);
    }
}
