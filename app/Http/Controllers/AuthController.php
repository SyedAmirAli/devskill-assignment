<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
    
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $request->session()->regenerate();
    
            return redirect()->intended('dashboard')->with('success', 'Login successful!');
        }
    
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    public function register(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username|max:255',
            'password' => 'required|min:6',
        ]);

        if($request->user()->is_admin){
            // Create a new user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->username,
                'username' => $request->username,
                'password' => Hash::make($request->password),
            ]); 

            return redirect()->back()->with('success', 'User created successfully!');
        }

        return back()->with('error', 'You are not authorized to perform this action!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Logged out successfully!');
    }
}
