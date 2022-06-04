<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class DashboardController extends Controller
{
    public function home()
    {
        // if (Auth::user()->role == 'mahasiswa'){
        //     $user = User::with('mahasiswa.judul')->find(Auth::user()->id);

        //     if ($user->mahasiswa->judul->status != 'Diproses'){
        //         $no_kp = 1;
        //         return view('dashboard', compact($no_kp));
        //     } else {
        //         return view('dashboard');
        //     }

        // } else {
            return view('dashboard');
        // }
    }
}
