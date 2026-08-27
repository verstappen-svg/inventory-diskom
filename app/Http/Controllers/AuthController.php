<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
<<<<<<< HEAD
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ], [
            'username.required' => 'Username wajib diisi.',
=======
        $request->validate([
            'Username' => ['required'],
            'password' => ['required'],
        ], [
            'Username.required' => 'Username wajib diisi.',
>>>>>>> c312f5b16b5e652a59efe8b8a431ce069767414e
            'password.required' => 'Password wajib diisi.',
        ]);

        $credentials = [
            'username' => $request->Username,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
<<<<<<< HEAD
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
=======

            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
>>>>>>> c312f5b16b5e652a59efe8b8a431ce069767414e
        }

        return back()
            ->withErrors([
                'username' => 'Username atau password salah.',
            ])
            ->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}