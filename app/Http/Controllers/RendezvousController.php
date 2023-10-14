<?php

namespace App\Http\Controllers;

use App\Models\Rendezvous;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RendezvousController extends Controller
{
    public function store(Request $request)
    {
        $medecins = User::all();
        $rendezvous = Rendezvous::all();

        $validator = Validator::make($request->all(), [
            'medecin' => 'required|exists:users,medecin_id',
            'name' => 'required',
            'firstname' => 'required',
            'date' => 'required|date',
            'heure' => 'required',
            'motif' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $rdv = new Rendezvous();
        $rdv->medecin_id = $request->input('medecin');
        $rdv->patient = $request->input('name').' '.$request->input('firstname');
        $rdv->date_et_heure = $request->input('date').'T'.$request->input('heure').':00';
        $rdv->motif = $request->input('motif');
        $rdv->duree = '15';
        $rdv->save();

        return view('medical', compact('medecins', 'rendezvous'));
    }

    public function storeMedecin(Request $request)
    {
        $medecins = User::all();
        $rendezvous = Rendezvous::all();

        $validator = Validator::make($request->all(), [
            'medecin-med' => 'required|exists:users,id',
            'name-med' => 'required',
            'firstname-med' => 'required',
            'date-med' => 'required|date',
            'heure-med' => 'required',
            'motif-med' => 'required',
            'duree-med' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $rdv = new Rendezvous();
        $rdv->medecin_id = $request->input('medecin-med');
        $rdv->patient = $request->input('name-med').' '.$request->input('firstname-med');
        $rdv->date_et_heure = $request->input('date-med').'T'.$request->input('heure-med').':00';
        $rdv->motif = $request->input('motif-med');
        $rdv->duree = $request->input('duree-med');
        $rdv->save();

        return view('medical', compact('medecins', 'rendezvous'));
    }
}
