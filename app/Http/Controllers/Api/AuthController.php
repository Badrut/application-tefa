<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate the request
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Attempt to authenticate the user
        if (!Auth::ttempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => $user->role,
        ]);
    }

    public function register(Request $request)
    {
        // Validate the request
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'username' => 'required|string|max:50|unique:users,username',
            'role' => 'required|string|in:admin,teacher,student,customer,supplier',
            'address' => 'nullable|string|max:500',
            'phone_number' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'role' => $data['role'],
            'password' => bcrypt($data['password']),
        ]);

        $userProfile = UserProfile::create([
            'user_id' => $user->id,
            'address' => $data['address'] ?? null,
            'phone_number' => $data['phone_number'] ?? null,
        ]);

        if($user->role === 'teacher') {
            $teacher = Teacher::create([
                'user_id' => $user->id,
                'nip' => str_pad($user->id, 5, '0', STR_PAD_LEFT),
                'is_active' => true,
            ]);
        } else if($user->role === 'student') {
            $student = Student::create([
                'user_id' => $user->id,
                'nis' => str_pad($user->id, 5, '0', STR_PAD_LEFT),
                'class' => 'Unknown',
                'year_of_entry' => date('Y'),
            ]);
        }

        return response()->json(['message' => 'User registered successfully'], 201);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
