@extends('layouts.app')
@section('title')
    Dashboard
@endsection
@section("styles")
<link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
@endsection
@section('content-dashboard')
@include("music")
@endsection