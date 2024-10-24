<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReportStatusRequest;
use App\Models\Report;
use App\Models\Student;
use App\Models\Tutor;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    //NORMAL USER METHODS INSERT HERE







    //ADMIN METHODS INSERT HERE
    public function showAllReports(Request $request)
    {
        $reports = Report::with('complainant')->paginate(10); // Automatically paginated

        foreach ($reports as $report) {
            $complainant_id = $report->complainant_id;
            $status = $report->status;

            $tutors = Tutor::where('user_id', $complainant_id)
                ->select('first_name', 'last_name', 'profile_image')
                ->first();

            $students = Student::where('user_id', $complainant_id)
                ->select('first_name', 'last_name', 'profile_image')
                ->first();

            if ($tutors) {
                $full_name = $tutors->first_name . ' ' . $tutors->last_name;
                $all_reports_info[] = [
                    'report_id' => $report->id,
                    'name' => $full_name,
                    'user_type' => 'Tutor',
                    'profile_image' => $tutors->profile_image,
                    'status' => $status,
                ];
            }

            if ($students) {
                $full_name = $students->first_name . ' ' . $students->last_name;
                $all_reports_info[] = [
                    'report_id' => $report->id,
                    'name' => $full_name,
                    'user_type' => 'Student',
                    'profile_image' => $students->profile_image,
                    'status' => $status,
                ];
            }
        }

        return response()->json([
            'message' => 'Reports retrieved successfully.',
            'all_reports_info' => $all_reports_info,
            'pagination' => [
                'total' => $reports->total(),
                'current_page' => $reports->currentPage(),
                'last_page' => $reports->lastPage(),
                'per_page' => $reports->perPage(),
            ],
        ]);
    }


    public function showReport(Request $request, $report_id)
    {
        // Retrieve the report by its ID
        $report = Report::find($report_id);

        // Check if the report exists
        if (!$report) {
            return response()->json(['message' => 'Report not found.'], 404);
        }

        // Fetch the complainant and offender user details
        $complainant = User::find($report->complainant_id);
        $offender = User::find($report->offender_id);

        // Prepare the response data
        $responseData = [
            'message' => 'Report retrieved successfully.',
            'report' => [
                'id' => $report->id,
                'status' => $report->status,
                'complainant' => $complainant ? [
                    'name' => $complainant->first_name . ' ' . $complainant->last_name,
                ] : null,
                'offender' => $offender ? [
                    'name' => $offender->first_name . ' ' . $offender->last_name,
                ] : null,
            ],
        ];

        return response()->json($responseData);
    }

    public function changeReportStatus(ReportStatusRequest $request, $report_id)
    {
        $validatedData = $request->validated();

        $report = Report::findOrFail($report_id);

        $report->status = $validatedData['status'];
        $report->save();

        return response()->json(['message' => 'Report status updated successfully.']);
    }
}
