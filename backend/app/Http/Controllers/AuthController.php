<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // VALIDATE
        $validatedData = $request->validate([
            'user_type' => 'required|exists:user_types,id',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',

            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'gender' => 'in:male,female,other',  // Assuming these options
            'contact_number' => 'required|string',
        ]);

        // REGISTER
        $user = User::create([
            'user_type' => $validatedData['user_type'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $userId = $user->id;
        $validatedDataWithUserId = array_merge($validatedData, ['user_id' => $userId]);

        // LOGIC FOR STUDENT OR TUTOR REGISTRATION
        $tutor = 1;
        if ($validatedData['user_type'] == $tutor) {
            (new TutorController)->createTutor($validatedDataWithUserId);
        }
        $student = 2;
        if ($validatedData['user_type'] ==  $student) {
            (new StudentController)->createStudent($validatedDataWithUserId);
        }

        // Generate token
        $token = $user->createToken('authToken')->plainTextToken;

        // Return JSON response
        return response()->json([
            'message' => 'User registered successfully!',
            'token' => $token,
        ], 201);
    }




    public function login(Request $request)
    {
        // VALIDATE INPUT
        $validatedData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // FIND USER BY EMAIL
        $user = User::where('email', $validatedData['email'])->first();

        // CHECK IF USER EXISTS AND PASSWORD MATCHES
        if (!$user || !Hash::check($validatedData['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid email or password.',
            ], 401); // Unauthorized
        }

        // GENERATE TOKEN
        $token = $user->createToken('authToken')->plainTextToken;

        // RETURN RESPONSE WITH TOKEN
        return response()->json([
            'message' => 'Login successful!',
            'token' => $token,
        ], 200);
    }



    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
