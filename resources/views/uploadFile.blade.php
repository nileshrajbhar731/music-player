@extends('layouts.app')
@section('title')
    Upload File
@endsection
@section('styles')
    <link href="{{ asset('css/uploadFile.css') }}" rel="stylesheet">
@endsection
@section('content-dashboard')
    <form class="form-container" method="POST" enctype="multipart/form-data" action="{{ url('store') }}">
        @csrf
        <div class="upload-files-container">
            <div class="drag-file-area">
                <span class="material-icons-outlined upload-icon"> file_upload </span>
                <h3 class="dynamic-message"> Drag & drop any file here </h3>
                <label class="label"> or <span class="browse-files"> <input type="file" class="default-file-input"
                            name="file" accept="audio/mp3" id="song-input" />
                        <span class="browse-files-text">browse file</span> <span>from device</span> </span> </label>
            </div>
            @error('file')
                <span class="cannot-upload-message"> <span class="material-icons-outlined">error</span> {{ $message }}<span
                        class="material-icons-outlined cancel-alert-button">cancel</span> </span>
            @enderror
            @if (session()->has('success'))
                <span class="file-upload-message"> <span class="material-icons-outlined">check_circle</span>
                    {{ session()->get('success') }} </span>
            @endif
            <div class="file-block">
                <div class="file-info"> <span class="material-icons-outlined file-icon">description</span> <span
                        class="file-name"> </span> | <span class="file-size"> </span> </div>
                <span class="material-icons remove-file-icon">delete</span>
                <div class="progress-bar"> </div>
            </div>
            <input type="text" hidden id="img" name="img">
            <button type="submit" class="upload-button"> Upload </button>
        </div>
    </form>
@endsection

@section('javascript')
    <script src="{{ asset('js/uploadFile.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsmediatags/3.9.5/jsmediatags.min.js"></script>
    <script>
        document.querySelector("#song-input").addEventListener("change", (event) => {

            const song = event.target.files[0]
            jsmediatags.read(song, {
                onSuccess: function(tag) {
                    console.log(tag)
                    // Array buffer to base64
                    const data = tag.tags.picture.data
                    const format = tag.tags.picture.format
                    let base64String = ""
                    for (let i = 0; i < data.length; i++) {
                        base64String += String.fromCharCode(data[i])
                    }
                    // Output the metadata
                    document.querySelector("#img").value =
                        `data:${format};base64,${window.btoa(base64String)}`

                },
                onError: function(error) {
                    console.log(error)
                }
            })
        })
    </script>
@endsection
