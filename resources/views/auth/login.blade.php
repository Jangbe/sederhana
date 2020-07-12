@extends('layout.auth')
@section('title', 'Login')
@section('link', 'login')
@section('content')
<div class="wrap-input100 validate-input m-b-16" data-validate = "Valid email is required: ex@abc.xyz">
    <input class="input100" type="text" name="email" placeholder="Email">
    <span class="focus-input100"></span>
    <span class="symbol-input100">
        <span class="lnr lnr-envelope"></span>
    </span>
</div>

<div class="wrap-input100 validate-input m-b-16" data-validate = "Password is required">
    <input class="input100" type="password" name="password" placeholder="Password">
    <span class="focus-input100"></span>
    <span class="symbol-input100">
        <span class="lnr lnr-lock"></span>
    </span>
</div>

<div class="contact100-form-checkbox m-l-4">
    <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember">
    <label class="label-checkbox100" for="ckb1">
        Simpan sandi
    </label>
</div>

<div class="container-login100-form-btn p-t-25">
    <button class="login100-form-btn" type="submit">
        Masuk
    </button>
</div>

<div class="text-center w-full p-t-90">
    <span class="txt1">
        Bukan member?
    </span>

    <a class="txt1 bo1 hov1" href="{{ url('/register')}}">
        Daftar sekarang juga							
    </a>
</div>
@endsection