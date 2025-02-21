<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }


    public function login(Request $request)
    {

        $request->validate([
            'mobile' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('mobile', 'password');
        \Log::debug('Login credentials', ['mobile' => $credentials['mobile']]);

        if (Auth::attempt(['mobile' => $credentials['mobile'], 'password' => $credentials['password'], 'is_active' => 1, 'is_deleted' => 0])) {
            \Log::info('Login successful', ['mobile' => $credentials['mobile']]);
            return redirect()->intended('dashboard');
        }
        \Log::warning('Login failed', ['mobile' => $credentials['mobile']]);
        throw ValidationException::withMessages([
            'mobile' => [trans('auth.failed')],
        ]);
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile' => 'required|string|max:255|unique:employees',
            'email' => 'required|string|email|max:255|unique:employees',
            'password' => 'required|string|confirmed|min:6',
        ]);

        UserEmployee::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/')->with('status', 'Registration successful! Please log in.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
