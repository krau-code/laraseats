<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    // Show admin login form
    public function adminLogin() {
        return view('adminLogin');
    }

    // Create new admin
    public function adminCreate(Request $request) {
        $formFields = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:6'
        ]);

        // Hash Password
        $formFields['password'] = bcrypt($formFields['password']);

        // Create User
        $user = User::create($formFields);

        // Login
        auth()->login($user);
    }

    // Show admin page
    public function adminIndex() {
        return view('adminIndex');
    }

    // Logout User
    public function adminLogout(Request $request) {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    // Authenticate User
    public function adminAuthenticate(Request $request) {
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if (auth()->attempt($formFields)) {
            $request->session()->regenerate();
        } else {
            return response()->json([
                'error' => 'Invalid credentials'
            ], 401);
        }
    }
}
