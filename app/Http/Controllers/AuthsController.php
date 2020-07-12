<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ongkir;
use App\User;
use Illuminate\Support\Facades\Auth;

class AuthsController extends Controller
{
    //
    public function masuk()
    {
        if(auth()->user()){
            return redirect('/');
        }
        return view('auth.login');
    }

    public function daftar()
    {
        if(auth()->user()){
            return redirect('/');
        }
        return view('auth.register');
    }

    public function login(Request $data)
    {
        $remember = $data->remember != null ? true : false;
        // dd($remember);
        if (Auth::attempt($data->only('email', 'password'), $remember )) {
            if(auth()->user()->role == 'admin'){
                return redirect('/admin')->with('pesan', ['pesan' => 'Login berhasil, silahkan berbelanja', 'type' => 'success']);
            }else{
                return redirect('/belanja')->with('pesan', ['pesan' => 'Login berhasil, silahkan berbelanja', 'type' => 'success']);
            }
        }
        return redirect('/')->with('pesan', ['pesan' => 'Login gagal, email atau password salah', 'type' => 'danger']);
    }

    public function register(Request $data)
    {
        $data->validate([
            'pass' => 'same:confirm'
        ]);
        if($data->pass == $data->confirm){
            User::create([
                'name'     => $data->name,
                'email'    => $data->email,
                'telepon'  => $data->telepon,
                'role'     => 'user',
                'password' => password_hash($data->pass, PASSWORD_DEFAULT)
            ]);
            return redirect('/belanja')->with('pesan', [
                'pesan' => 'Data berhasil ditambahkan',
                'type'  => 'success']);
        }else{
            return redirect('/')->with('pesan', [
                'pesan' => 'Data gagal ditambahkan, Password sama Konfirmasi password beda!',
                'type'  => 'danger']);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
