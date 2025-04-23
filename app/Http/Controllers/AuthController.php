<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
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

        $token = JWTAuth::fromUser($user);

        return response()->json(['user' => $user, 'token' => $token], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json(['token' => $token]);
    }

    public function profile()
    {
        // Gunakan auth('api') untuk mendapatkan user yang terautentikasi menggunakan JWT
        return response()->json(auth('api')->user());
    }

    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();  // Mengambil user yang sedang login melalui JWT

        

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $data = $request->validate([
            'name' => 'sometimes|string',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
        ]);

        // Update user
        /** @var \App\Models\User $user */
        $user->update($data);  // Jika $user adalah instansi dari model User, metode update seharusnya tersedia.

        return response()->json(['message' => 'Profile updated', 'user' => $user]);
    }
}
