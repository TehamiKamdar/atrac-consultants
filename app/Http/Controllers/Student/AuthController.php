<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (auth()->check() && auth()->user()->user_type === 'student' && auth()->user()->status === 'active') {
            return redirect()->route('student.dashboard');
        }
        return view('student.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $login = $request->input('login');

        $field = filter_var($login, FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'username';

        if (Auth::attempt([
            $field => $login,
            'password' => $request->password,
            'user_type' => 'student',
        ])) {
            if(Auth::user()->status === "active"){

                $request->session()->regenerate();

                return redirect()->route('student.dashboard');

            }else{
                return back()
                ->withErrors([
                    'login' => 'Your account status is inactive. Contact Us for more details',
                ])
                ->withInput($request->only('login'));
                
            }
        }

        return back()
            ->withErrors([
                'login' => 'Invalid username/email or password.',
            ])
            ->withInput($request->only('login'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('student.login');
    }
}
