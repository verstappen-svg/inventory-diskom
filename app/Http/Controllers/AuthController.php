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
        $credentials = $request->validate([
            'Username' => ['required'],
            'password' => ['required'],
        ], [
            'Username.required' => 'Username wajib diisi.',
            'Username.Username' => 'Format Username tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (Auth::attempt($credentials)) {

        $request->session()->regenerate();

        return redirect()->intended('/dashboard');
        }

        return back()
            ->withErrors([
                'Username' => 'Username atau password salah.',
            ])
            ->onlyInput('Username');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}