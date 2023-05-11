{{-- logo and name --}}
<div class="logo_container">
    <div class="logo_row">
        <div class="logo">
            <div class="logo_img"><img src="{{ asset('image/logo_music (2).png') }}" alt=""></div>
        </div>


        @if (auth()->check())
        <div class="website_url">
                <li class=""><a href="">{{ Session::get('email') }}</a></li>
                <li class="profile_img"><a href="{{ URL::to('profile') }}"> 
                    {{-- <div class="profile_row">
                        <img src="{{ Session::get('avatar') }}" class="profile">
                    </div> --}}
                    
                    Profile
                    </a></li>
                <li class=""><a href="/logOut">Log Out</a></li>

            </div>
        @else
            <div class="website_url">
                <li class=""><a href="/">Home</a></li>
                <li class=""><a href="/aboutUs">About</a></li>
                <li class=""><a href="/contactUs">Contact</a></li>
                <li class=""><a href="/login">Login</a></li>
                <li class=""><a href="/signin">Sign In</a></li>
            </div>
        @endif


    </div>
</div>
@if (auth()->check())
    <div class="row">
        <div class="navbar_container">
            <div class="navbar_button">
                <li>
                    <a href="/dashboard">
                        <button class="home">
                            <i class="fa-solid fa-house-chimney"></i>
                            <i class="fa-solid fa-compact-disc"></i>
                            <i class="fa-solid fa-music"></i>
                        </button>
                    </a>
                </li>
                {{--  --}}
                <li>
                    <a href="/song-like">
                        <button class="home">
                            <i class="fa-solid fa-music"></i>
                            <i class="fa-solid fa-heart" style="color: #ff0000;"></i>
                            <i class="fa-solid fa-play"></i>
                        </button>
                    </a>
                </li>
                {{--  --}}
                <li>
                    <a href="/youtube-link">
                        <button class="home">
                            <i class="fa-brands fa-youtube red"></i>
                            <i class="fa-solid fa-link link"></i>
                            <i class="fa-solid fa-music "></i>
                        </button>
                    </a>
                </li>
                {{--  --}}
                <li>
                    <a href="/upload-file">
                        <button class="home">
                            <i class="fa-solid fa-file-audio audio"></i>
                            <i class="fa-solid fa-cloud-arrow-up upload"></i>
                            <i class="fa-solid fa-music music"></i>
                        </button>
                    </a>
                </li>
                {{--  --}}
                <li>
                    <a href="/music-analysis">
                        <button class="home">
                            <i class="fa-solid fa-music"></i>
                            <i class="fa-solid fa-database"></i>
                            <i class="fa-solid fa-magnifying-glass-chart"></i>
                        </button>
                    </a>
                </li>
            </div>
        </div>
        {{-- after login content --}}
        @yield('content-dashboard')
    </div>
@else
    {{-- all page content --}}
    @yield('content')
@endif


{{-- @include('footer.footer') --}}
