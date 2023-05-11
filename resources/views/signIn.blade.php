@extends('layouts.app')
@section('title')
    Sign In
@endsection
@section("styles")
<link href="{{ asset('css/signIn.css') }}" rel="stylesheet">
@endsection
@section('content')
@if (session()->has('error'))
                <span class="file-upload-message"> <span class="material-icons-outlined">check_circle</span>
                    {{ session()->get('error') }} </span>
            @endif
<div class="img_login">
    <form action="{{ url('signin/store') }}" method="post" class="form">
        <h1>Sign In</h1>
        @csrf
        <input type="text" name="fn" placeholder="Full Name" class="input" />
        @error('fn')
        {{ $message }}
        @enderror
        <input type="text" name="email"  placeholder="Email" class="input" />
        @error('email')
        {{ $message }}
        @enderror
        <input type="password" name="password"  placeholder="Password" class="input" />
        @error('password')
        {{ $message }}
        @enderror
        <input type="password" name="password_confirmation"  placeholder="Re-password" class="input" />
        @error('repassword')
        {{ $message }}
        @enderror
        <button class="btn">Sign In</button>
        <!-- <div class="flex items-center justify-end mt-4">
            <a class="btn" href="{{ url('auth/google') }}" style="background: #9e49ff; color: #ffffff; padding: 10px; width: 100%; text-align: center; display: block; border-radius:3px;">
                Login with Google
            </a>
        </div> -->
      </form>
</div>
@endsection