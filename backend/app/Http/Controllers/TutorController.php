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
        ]);
        return [
            'message' => 'Tutor successfully created',
        ];
    }
}
