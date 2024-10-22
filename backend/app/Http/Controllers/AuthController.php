<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\LogoutUserRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Models\Admin;
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

        $userType = match ($user->user_type) {
            1 => 'tutor',
            2 => 'student',
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
        // VALIDATE INPUT
        $validatedData = $request->validated();

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

        $userType = match ($user->user_type) {
            1 => 'tutor',
            2 => 'student',
            default => 'unknown',
        };

        // RETURN RESPONSE WITH TOKEN
        return response()->json([
            'message' => 'Login successful!',
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
            'message' => 'Login successful!',
            'user_type' => "admin",
            'token' => $token,
        ], 200);
    }


    public function logout(LogoutUserRequest $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
