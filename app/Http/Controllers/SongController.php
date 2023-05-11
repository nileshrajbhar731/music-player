<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SongController extends Controller
{
    //
    public function index()
    {
        $email = Session::get('email');
        $likes = Like::whereHas('file', function ($query) use ($email) {
            $query->where('email', $email);
        })
            ->orderBy('created_at', 'desc')
            ->get();
        return view('SongLike')->with('likes', $likes);
        // var_dump($likes);

    }

    public function store($request)
    {

        $save = new Like;
        $email = Session::get('email');
        $save->email = $email;
        $save->file_id = $request;
        $save->save();

        return $this->index();
    }
    public function likeRemove($request)
    {

        Like::where('id', $request)->delete();

        return redirect('song-like');
    }
}