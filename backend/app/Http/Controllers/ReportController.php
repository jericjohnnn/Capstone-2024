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
        $reports = Report::with('complainant.tutor', 'complainant.student', 'complainant.userType')->get();

        $complainantReport = $reports->map(function ($report) {
            $first_name = $report->complainant->tutor?->first_name ??
                $report->complainant->student?->first_name ??
                null;
            $last_name = $report->complainant->tutor?->last_name ??
                $report->complainant->student?->last_name ??
                null;

            return [
                'id' => $report->id,
                'complainant_name' => $first_name && $last_name ?
                    "$first_name $last_name" :
                    $first_name ?? $last_name ?? null,
                'complainant_profile_image' => $report->complainant->tutor?->profile_image ??
                    $report->complainant->student?->profile_image ??
                    null,
                'complainant_user_type' => $report->complainant->userType->type,
                'report_status' => $report->status,
            ];
        });

        return response()->json([
            'message' => 'All reports retrieved successfully.',
            'complainant_report' => $complainantReport,
        ]);
    }


    public function showReport(Request $request, $report_id)
    {
        $reports = Report::where('id', $report_id)
            ->with('complainant.tutor', 'complainant.student', 'complainant.userType', 'offender.tutor', 'offender.student', 'offender.userType')
            ->first();

        $complainant_first_name = $reports->complainant->tutor?->first_name ??
            $reports->complainant->student?->first_name ??
            null;
        $complainant_last_name = $reports->complainant->tutor?->last_name ??
            $reports->complainant->student?->last_name ??
            null;

        $offender_first_name = $reports->offender->tutor?->first_name ??
            $reports->offender->student?->first_name ??
            null;
        $offender_last_name = $reports->offender->tutor?->last_name ??
            $reports->offender->student?->last_name ??
            null;

        $report_data = [
            'message' => 'Report retrieved successfully.',
            'report_id' => $reports->id,
            'report_title' => $reports->title,
            'report_message' => $reports->message,

            'complainant_name' => $complainant_first_name && $complainant_last_name ?
                "$complainant_first_name $complainant_last_name" :
                $complainant_first_name ?? $complainant_last_name ?? null,
            'complainant_profile_image' => $reports->complainant->tutor?->profile_image ??
                $reports->complainant->student?->profile_image ??
                null,
            'complainant_user_type' => $reports->complainant->userType->type,
            'offender_name' => $offender_first_name && $offender_last_name ?
                "$offender_first_name $offender_last_name" :
                $offender_first_name ?? $offender_last_name ?? null,
            'offender_profile_image' => $reports->offender->tutor?->profile_image ??
                $reports->offender->student?->profile_image ??
                null,
            'offender_user_type' => $reports->offender->userType->type,
            'offender_offense_status' => $reports->offender->tutor?->offense_status ??
                $reports->offender->student?->offense_status ??
                null,
            'offender_contact_number' => $reports->offender->tutor?->contact_number ??
                $reports->offender->student?->contact_number ??
                null,
            'offender_address' => $reports->offender->tutor?->address ??
                $reports->offender->student?->address ??
                null,
            'report_status' => $reports->status,
        ];
        return response()->json(
            [
                'message' => 'Report retrieved successfully.',
                'report_data' => $report_data,
            ]
        );
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
