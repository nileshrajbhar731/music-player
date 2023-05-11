@extends('layouts.app')
@section('title')
    Youtube Link
@endsection
@section('styles')
    <link href="{{ asset('css/youtubeLink.css') }}" rel="stylesheet">
@endsection
@section('content-dashboard')
    <div class="app">
        <section class="content">
            <h1 class="content_title">YouTube to MP3 Converter</h1>
            <p class="content_description">
                Transform YouTube videos into MP3s in just a few clicks!
            </p>

            <form class="form" method="POST" enctype="multipart/form-data" action="{{ url('youtube-store') }}">
                @csrf
                <input placeholder="Paste a Youtube video URL link..." class="form_input" type="text" name="link" />
                <button type="submit" class="form_button">Search</button>
            </form>
            @error('link')
                <span class="cannot-upload-message"> <span class="material-icons-outlined">error</span> {{ $message }}
                    <span class="material-icons-outlined cancel-alert-button">cancel</span> </span>
            @enderror
            @if ($errors->has('youtubeLink'))
                <span class="cannot-upload-message"> <span class="material-icons-outlined">error</span> {{ $errors->first('youtubeLink') }}
                    <span class="material-icons-outlined cancel-alert-button">cancel</span> </span>
            @endif

            @if (session()->has('youtubeLink'))
                <span class="youtubeLink"> <span class="material-icons-outlined">check_circle</span>
                    <i class="fa-solid fa-arrow-right"></i>
                    <a href="{{ session()->get('youtubeLink') }} " target="_blank" rel="noopener noreferrer">Download</a>
                    <i class="fa-solid fa-arrow-right"></i> <a href="/upload-file">Upload File</a>
                </span>
            @endif

        </section>
    </div>

    {{-- <script>
    const options = {
	method: 'GET',
	headers: {
		'X-RapidAPI-Key': '2fbb89fad7mshd0dd7a621d48316p1c052djsn5ccb558dcc70',
		'X-RapidAPI-Host': 'youtube-mp36.p.rapidapi.com'
	}
};

fetch('https://youtube-mp36.p.rapidapi.com/dl?id=TFX19GQ8LMQ', options)
	.then(response => response.json())
	.then(response => console.log(response.link))
	.catch(err => console.error(err));
</script> --}}
@endsection
