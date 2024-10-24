<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tutor;
use Illuminate\Http\Request;

class TutorController extends Controller
{
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
}
