<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Jobs\SendAuthNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:6'
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password'])
            ]);

            // Kirim notifikasi registrasi
            SendAuthNotification::dispatch($user, 'register');

            $token = JWTAuth::fromUser($user);

            return response()->json([
                'status' => 'success',
                'code' => 201,
                'message' => 'User registered successfully',
                'data' => [
                    'user' => $user,
                    'token' => $token
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'code' => 500,
                'message' => 'Registration failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function verifyEmail($token)
    {
        try {
            $user = User::where('email_verification_token', $token)->first();

            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'code' => 404,
                    'message' => 'Invalid verification token'
                ], 404);
            }

            $user->email_verified_at = now();
            $user->email_verification_token = null;
            $user->save();

            return response()->json([
                'status' => 'success',
                'code' => 200,
                'message' => 'Email verified successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'code' => 500,
                'message' => 'Email verification failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json([
                'status' => 'error',
                'code' => 401,
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = auth('api')->user();
        
        // Kirim notifikasi login
        SendAuthNotification::dispatch($user, 'login');

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Login successful',
            'token' => $token
        ]);
    }

    public function profile()
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'User profile fetched',
            'data' => $user
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'User not found'
            ], 404);
        }

        $data = $request->validate([
            'name' => 'sometimes|string',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
        ]);

        /** @var \App\Models\User $user */
        $user->update($data);

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Profile updated successfully',
            'data' => $user
        ]);
    }
}
