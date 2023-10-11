<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return redirect()->back()->withErrors([
                'email' => 'L\'identifiant fourni n\'existe pas.',
            ]);
        }

        if (Auth::attempt($credentials)) {
            if (Hash::check($credentials['password'], $user->password)) {
                return redirect()->route('medical');
            }
        }

        return redirect()->route('error')->withErrors([
            'password' => 'Le mot de passe fourni est incorrect.',
        ]);
    }


    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->route('medical');
    }
}
