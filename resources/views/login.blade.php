@extends('layouts.app')
@section('title')
    Login
@endsection
@section("styles")
<link href="{{ asset('css/login.css') }}" rel="stylesheet">
@endsection
@section('content')

<div class="img_login">
    <form action="{{ url('login/auth') }}" method="post" class="form">
        <h1>LOGIN</h1>
        @csrf
        <input type="text" name="email" placeholder="Username" class="input" />
        <input type="password" name="password" placeholder="Password" class="input" />
        <button class="btn">LOGIN</button>
        <div class="flex items-center justify-end mt-4">
            <a class="btn" href="{{ url('auth/google') }}" style="background: #9e49ff; color: #ffffff; padding: 10px; width: 100%; text-align: center; display: block; border-radius:3px;">
                Login with Google
            </a>
        </div>
      </form>
</div>

@endsection