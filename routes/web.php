<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RendezvousController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        return view('medical', compact('medecins', 'rendezvous'));
    }

    return view('medical');
})->name('medical');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/new-rdv', [RendezvousController::class, 'store'])->name('new-rdv');
Route::post('/new-rdv-medecin', [RendezvousController::class, 'storeMedecin'])->name('new-rdv-medecin');

Route::get('/error', function () {
    return view('error');
})->name('error');
