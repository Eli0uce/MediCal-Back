<?php

namespace App\Http\Controllers;

use App\Models\Rendezvous;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $medecins = User::all();
        $rendezvous = Rendezvous::all();

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('error')->withErrors($validator);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (Hash::check($credentials['password'], Auth::user()->password)) {
                return view('medical', compact('medecins', 'rendezvous'));
            } else {
                return redirect()->route('error')->withErrors([
                    'password' => 'Le mot de passe fourni est incorrect.',
                ]);
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
