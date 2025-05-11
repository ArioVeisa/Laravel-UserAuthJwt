<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Jobs\SendAuthNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

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
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Dispatch job ke queue
            SendAuthNotification::dispatch($user, 'register');

            $token = JWTAuth::fromUser($user);

            return response()->json([
                'message' => 'Registrasi berhasil',
                    'user' => $user,
                    'token' => $token
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error dalam registrasi: ' . $e->getMessage());
            return response()->json([
                'message' => 'Terjadi kesalahan dalam registrasi',
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
        try {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

        $credentials = $request->only('email', 'password');

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json([
                    'message' => 'Email atau password salah'
            ], 401);
        }

            $user = auth('api')->user();

            // Dispatch job ke queue
            SendAuthNotification::dispatch($user, 'login');

        return response()->json([
                'message' => 'Login berhasil',
                'token' => $token,
                'token_type' => 'Bearer',
                'user' => $user
            ]);
        } catch (\Exception $e) {
            Log::error('Error dalam login: ' . $e->getMessage());
            return response()->json([
                'message' => 'Terjadi kesalahan dalam login',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function profile()
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'message' => 'Data profil berhasil diambil',
            'user' => $user
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        $data = $request->validate([
            'name' => 'sometimes|string',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
        ]);

        User::where('id', $user->id)->update($data);

        return response()->json([
            'message' => 'Profil berhasil diperbarui',
            'user' => $user
        ]);
    }
}
