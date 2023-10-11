<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Rendezvous;
use Illuminate\Support\Facades\Auth;

class MedicalController extends Controller
{
    public function getAll()
    {
        $medecins = User::all();
        $rendezvous = Rendezvous::all();
        // authentifie l'utilisateur et le redirige vers la page d'accueil
        if (Auth::check()) {
            return view('medical', compact('medecins', 'rendezvous'));
        }
    }
}
