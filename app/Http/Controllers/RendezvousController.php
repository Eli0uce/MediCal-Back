<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Rendezvous;
use App\Models\User;

class RendezvousController extends Controller
{
    public function store(Request $request)
    {
        $medecins = User::all();
        $rendezvous = Rendezvous::all();

        $validator = Validator::make($request->all(), [
            'medecin' => 'required',
            'date' => 'required',
            'heure' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('error')->withErrors($validator);
        }

        $rdv = new Rendezvous();
        $rdv->medecin_id = $request->input('medecin');
        $rdv->patient = $request->input('name') . ' ' . $request->input('firstname');
        $rdv->date_et_heure = $request->input('date') . 'T' . $request->input('heure');
        $rdv->motif = $request->input('motif');
        $rdv->duree = $request->input('duree');
        $rdv->save();

        return view('medical', compact('medecins', 'rendezvous'));
    }
}
