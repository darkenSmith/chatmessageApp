<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 400);
        }

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        // Log the user in after registration
        Auth::login($user);

        // Return success response with user data
        return response()->json([
            'message' => 'Registration successful',
            'user' => $user,
        ], 201);
    }
    public function login(Request $request): JsonResponse
    {
        // Validate the incoming request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Attempt to log the user in
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Authentication passed, return a success response
            return response()->json([
                'message' => 'Login successful',
                'user' => Auth::user(),
                'token' => Auth::user()->createToken('token')->plainTextToken
            ]);
        }

        // Authentication failed
        return response()->json([
            'message' => 'Invalid email or password',
        ], 401);

    }

    public function logout(): JsonResponse
    {
        // Log out the user from the session
        Auth::logout();

        return response()->json([
            'message' => 'Logout successful',
        ]);
    }
}
