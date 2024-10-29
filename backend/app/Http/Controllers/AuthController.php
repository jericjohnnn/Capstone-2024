<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\LogoutUserRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Models\Admin;
use App\Models\Student;
use App\Models\Tutor;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        // VALIDATE
        $validatedData = $request->validated();

        // REGISTER
        $user = User::create([
            'user_type_id' => $validatedData['user_type_id'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $userId = $user->id;
        $validatedDataWithUserId = array_merge($validatedData, ['user_id' => $userId]);

        // LOGIC FOR STUDENT OR TUTOR REGISTRATION
        $tutor = 2;
        if ($validatedData['user_type_id'] == $tutor) {
            (new TutorController)->createTutor($validatedDataWithUserId);
        }
        $student = 1;
        if ($validatedData['user_type_id'] ==  $student) {
            (new StudentController)->createStudent($validatedDataWithUserId);
        }

        // Generate token
        $token = $user->createToken('authToken')->plainTextToken;

        $userType = match ($user->user_type_id) {
            1 => 'Student',
            2 => 'Tutor',
            default => 'unknown',
        };

        // Return JSON response
        return response()->json([
            'message' => 'User registered successfully!',
            'user_type' => $userType,
            'token' => $token,
        ], 201);
    }


    public function userLogin(LoginUserRequest $request)
    {
        $validatedData = $request->validated();

        $user = User::where('email', $validatedData['email'])->first();

        if (!$user || !Hash::check($validatedData['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid email or password.',
            ], 401); // Unauthorized
        }

        $token = $user->createToken('authToken')->plainTextToken;

        $userFullName = null;
        $userType = null;
        if ($user->user_type_id === 1) {
            $student = Student::where('user_id', $user->id)->first();
            $userFullName = "{$student->first_name} {$student->last_name}";
            $userType = "Student";
        } elseif ($user->user_type_id === 2) {
            $tutor = Tutor::where('user_id', $user->id)->first();
            $userFullName = "{$tutor->first_name} {$tutor->last_name}";
            $userType = "Tutor";
        }

        return response()->json([
            'message' => 'Login successful!',
            'user_email' => $user->email,
            'user_full_name' => $userFullName,
            'user_type' => $userType,
            'token' => $token,
        ], 200);
    }


    public function adminLogin(LoginUserRequest $request)
    {
        // VALIDATE INPUT
        $validatedData = $request->validated();

        // FIND USER BY EMAIL
        $admin = Admin::where('email', $validatedData['email'])->first();

        // CHECK IF USER EXISTS AND PASSWORD MATCHES
        if (!$admin || !Hash::check($validatedData['password'], $admin->password)) {
            return response()->json([
                'message' => 'Invalid email or password.',
            ], 401); // Unauthorized
        }

        // GENERATE TOKEN
        $token = $admin->createToken('authToken')->plainTextToken;

        // RETURN RESPONSE WITH TOKEN
        return response()->json([
            'message' => 'Admin login successful!',
            'user_type' => "Admin",
            'token' => $token,
        ], 200);
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
