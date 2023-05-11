@extends('layouts.app')
@section('title')
Music Analysis
@endsection
@section('styles')
    <link href="{{ asset('css/musicAnalysis.css') }}" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
@endsection
@section('content-dashboard')

<div class="container_analysis">
  
    <section class="home-section">

    
        <div class="home-content">
          <div class="overview-boxes">
            <div class="box">
              <div class="right-side">
                <div class="box-topic">Today</div>
                <div class="number">40,876</div>

              </div>
             <i class="fa-solid fa-calendar-day cart"></i>
            </div>
            <div class="box">
              <div class="right-side">
                <div class="box-topic">Yesterday</div>
                <div class="number">38,876</div>
              </div>
              <i class='fa-solid fa-calendar-day cart two' ></i>
            </div>
            <div class="box">
              <div class="right-side">
                <div class="box-topic">Weak</div>
                <div class="number">$12,876</div>
              </div>
              <i class="fa-solid fa-calendar-week cart three"></i>
            </div>
            <div class="box">
              <div class="right-side">
                <div class="box-topic">Month</div>
                <div class="number">11,086</div>
              </div>
              <i class="fa-solid fa-calendar-days cart four"></i>
            </div>
            <div class="box">
              <div class="right-side">
                <div class="box-topic">Year</div>
                <div class="number">11,086</div>
              </div>
              <i class="fa-solid fa-calendar cart four"></i>
            </div>
          </div>
        </div>
      </section>
</div>










@endsection
