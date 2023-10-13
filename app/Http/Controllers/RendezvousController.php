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
            'medecin' => 'required',
            'name' => 'required',
            'firstname' => 'required',
            'date' => 'required',
            'heure' => 'required',
            'motif' => 'required',
            'duree' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $rdv = new Rendezvous();
        $rdv->medecin_id = $request->input('medecin');
        $rdv->patient = $request->input('name').' '.$request->input('firstname');
        $rdv->date_et_heure = $request->input('date').'T'.$request->input('heure').':00';
        $rdv->motif = $request->input('motif');
        $rdv->duree = $request->input('duree');
        $rdv->save();

        return view('medical', compact('medecins', 'rendezvous'));
    }
}
