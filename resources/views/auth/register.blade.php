@extends('layout.auth')
@section('link', 'register')
@section('title', 'Daftar')
@section('content')

<div class="wrap-input100 validate-input m-b-16" data-validate = "Nama Lengkap harus di isi">
    <input class="input100" type="text" name="name" placeholder="Nama Lengkap">
    <span class="focus-input100"></span>
    <span class="symbol-input100">
        <span class="lnr lnr-user"></span>
    </span>
</div>

<div class="wrap-input100 validate-input m-b-16" data-validate = "Email harus di isi: ex@abc.xyz">
    <input class="input100" type="text" name="email" placeholder="Email">
    <span class="focus-input100"></span>
    <span class="symbol-input100">
        <span class="lnr lnr-envelope"></span>
    </span>
</div>

<div class="wrap-input100 validate-input m-b-16" data-validate = "No Telepon harus di isi">
    <input class="input100" type="text" name="telepon" placeholder="Nomer Telepon">
    <span class="focus-input100"></span>
    <span class="symbol-input100">
        <span class="lnr lnr-phone"></span>
    </span>
</div>

<div class="wrap-input100 validate-input m-b-16" data-validate = "Password harus di isi">
    <input class="input100" type="password" name="pass" placeholder="Password">
    <span class="focus-input100"></span>
    <span class="symbol-input100">
        <span class="lnr lnr-lock"></span>
    </span>
</div>

<div class="wrap-input100 validate-input m-b-16" data-validate = "Konfirmasi Password harus di isi">
    <input class="input100" type="password" name="confirm" placeholder="Password">
    <span class="focus-input100"></span>
    <span class="symbol-input100">
        <span class="lnr lnr-lock"></span>
    </span>
</div>

{{-- <div class="contact100-form-checkbox m-l-4">
    <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
    <label class="label-checkbox100" for="ckb1">
        Remember me
    </label>
</div> --}}

<div class="container-login100-form-btn p-t-25">
    <button class="login100-form-btn" type="submit">
        Daftar
    </button>
</div>

<div class="text-center w-full p-t-50">
    <span class="txt1">
        Sudah punya akun?
    </span>

    <a class="txt1 bo1 hov1" href="{{ url('/login')}}">
        Silahkan masuk						
    </a>
</div>
@endsection