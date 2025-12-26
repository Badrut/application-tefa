<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginView(){
        if(Auth::check()){
            $user = Auth::user();
            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            }

            if ($user->hasRole('teacher')) {
                return redirect()->route('teacher.dashboard');
            }

            if ($user->hasRole('student')) {
                return redirect()->route('student.dashboard');
            }

            if ($user->hasRole('customer')) {
                return redirect()->route('customer.dashboard');
            }

            if ($user->hasRole('supplier')) {
                return redirect()->route('supplier.dashboard');
            }
        } else {
            return view('auth.login');
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string|min:6',
        ]);
        if (!Auth::attempt($credentials)) {
            return back()->withErrors(['username' => 'Username atau password salah']);
        }

        $session = $request->session()->regenerate();
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRole('teacher')) {
            return redirect()->route('teacher.dashboard');
        }

        if ($user->hasRole('student')) {
            return redirect()->route('student.dashboard');
        }

        if ($user->hasRole('customer')) {
            return redirect()->route('customer.dashboard');
        }

        if ($user->hasRole('supplier')) {
            return redirect()->route('supplier.dashboard');
        }

        Auth::logout();
        return back()->withErrors(['role' => 'Role tidak dikenali']);
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
                'year_of_entry' => now()->year,
            ]);
        }

        return view('auth.login')->with('success', 'Registration successful. Please login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return view('auth.login')->with('success', 'Logged out successfully.');
    }
}
