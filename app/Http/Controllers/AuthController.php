<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function logged(Request $request)
    {
        $validated = $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $isLogged = Auth::attempt($validated);

        if ($isLogged) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->with('logged_error', 'Email atau password salah');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('auth.login');
    }
}
