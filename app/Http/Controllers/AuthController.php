<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\TahunAjaran;

class AuthController extends Controller
{
    public function login(){
        return view('auth.login');
    }
    public function postlogin(Request $request){
        $tahun = TahunAjaran::where('status', 'Aktif')->value('id');

        if (Auth::attempt($request->only('username', 'password'))){
            $role = Auth::user()->where('username', $request->username)->value('role');
            $tahun_id = Auth::user()->where('username', $request->username)->value('tahun_ajaran_id');

            if($role == 'koordinator'){
                return redirect()->route('dashboard.home');
            }
            else {
                if($tahun_id == $tahun){
                    return redirect()->route('dashboard.home');
                } else {
                    Auth::logout();
                    return redirect('/login')->with('msg','Akun Anda Kadaluarsa');
                }
            }
        }
        else {
            return back()->with('msg','Kredensial salah, silakan coba lagi');
        }
    }

    public function logout(){
    	Auth::logout();
    	return redirect('/login');
    }

    // public function reject(){
    // 	return view('reject');
    // }
}
