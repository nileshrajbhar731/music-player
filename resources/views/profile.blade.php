@extends('layouts.app')
@section('title')
    Profile
@endsection
@section('styles')
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
@endsection

@section('content-dashboard')
    <style>
        .cover-photo {
            position: relative;
            background: url("{{ Session::get('avatar') }}");
            background-size: cover;
            height: 180px;
            border-radius: 5px 5px 0 0;
        }
    </style>
    <div class="card-box">

        <div class="card">
            <div class="cover-photo">
                <img src="{{ Session::get('avatar') }}" class="profile">
            </div>
            <h3 class="profile-name">{{ Session::get('name') }}</h3>
            <p class="about">{{ Session::get('email') }} <br>
                @if (Session::get('email_verified') === '1')
                    <i class="fa-solid fa-circle-check"></i>
            </p>
            @endif

            <button class="btn">Remove</button>

        </div>
    </div>
@endsection
