<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
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
            'username' => ['required'],
            'password' => ['required'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (Auth::attempt($credentials)) {

            if (!auth()->user()->is_active) {
                Auth::logout();
                return back()->withErrors([
                    'username' => 'Akun ini sudah dinonaktifkan.',
                ])->onlyInput('username');
            }

            $request->session()->regenerate();

            auth()->user()->update(['last_login_at' => now()]);

            ActivityLog::record(
                'User "' . auth()->user()->name . '" login',
                'login'
            );

            return redirect()->intended(route('dashboard'));
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