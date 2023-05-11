@extends('layouts.app')
@section('title')
    Song Like
@endsection
@section('styles')
    <link href="{{ asset('css/songLike.css') }}" rel="stylesheet">
@endsection
@section('content-dashboard')
    <style>
        .box_playlist {
            width: 100%;
            /* background: red; */
            display: flex;
            justify-content: center;
        }

        .playlist {
            /* display: flex;
                        justify-content: center; */
            width: 50%;
            height: 550px;
            margin: 15px;
            background: white;
            overflow: scroll;
            overflow-x: hidden;
            /* overflow-y: hidden; */
        }

        .playlist_Detalis {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            background: black;
            color: white;
            margin: 10px;
            padding: 10px;
            height: 100px;

        }

        .playlist_Detalis .playlist_img {
            width: 130px;
            padding: 5px;

        }

        .playlist_Detalis .playlist_img img {
            width: 100%;
            border-radius: 10px;
        }

        .playlist_Detalis .playlist_songList {
            width: 80%;
        }
    </style>

    <div class="box_playlist">
        <div class="playlist">
            @foreach ($likes as $like)
                <div class="playlist_Detalis">
                    <div class="playlist_img">
                        <img src="{{ $like->file->img }}" alt="">
                    </div>
                    <div class="playlist_songList">
                        <p class="playlist_title">{{ $like->file->title }}</p>
                        <p class="playlist_title">{{ $like->file->playtime }}</p>
                        <a href="{{ url('likeRemove/' . $like->id) }}"><i class="fa-solid fa-trash"></i></a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
