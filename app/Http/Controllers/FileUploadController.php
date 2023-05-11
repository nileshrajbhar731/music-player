<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Owenoj\LaravelGetId3\GetId3;
use Illuminate\Support\Facades\Storage;
use Session;
use GuzzleHttp\Client;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileUploadController extends Controller
{
    public function index()
    {
        return view('uploadFile');
    }

    public function store(Request $request)
    {

        $data = request()->all();
        // var_dump( $data);
        $request->validate([
            'file' => 'required|mimes:mp3',
        ], [
            'file.required' => 'Please select a file.',
            'file.mimes' => 'Please select an MP3 file.',
        ]);


        $track = new GetId3($request->file('file'));

        // // var_dump($track->extractInfo());
        // var_dump($track->getTitle());
        $title = $track->getTitle() ? $track->getTitle() : '';
        // var_dump($title);
        // var_dump($track->getArtist());
        $artist = $track->getArtist() ? $track->getArtist() : '';
        // var_dump($track->getAlbum());
        $album = $track->getAlbum() ? $track->getAlbum() : '';
        // var_dump($track->getPlaytime());
        $playtime = $track->getPlaytime() ? $track->getPlaytime() : '';
        // var_dump($track->getPlaytimeSeconds());
        $genres = $track->getGenres() ? $track->getGenres() : '';
        // var_dump($genres[0]);

        // var_dump($track->getComposer());
        $composer = $track->getComposer() ? $track->getComposer() : '';

         $id = Session::get('id');


        $isFile = true;
        $isOffline = true;


        $fileName = $request->file('file')->getClientOriginalName();
        $fileType = str_replace('.', '', strrchr($fileName, '.'));;
        // var_dump($fileType);

        $path = $request->file('file')->store('public/files');
        $url = str_replace('public/', '', $path);
        // var_dump($url);


        $save = new File;

        $save->user_id = $id;
        $save->fileName = $fileName;
        $save->fileType = $fileType;
        $save->url = $url;
        $save->img = $data['img'] === NULL ? '' : $data['img'];
        $save->title = $title;
        $save->artist = $artist;
        $save->album = $album;
        $save->playtime = $playtime;
        $save->genres = $genres === '' ? '' : $genres[0];
        $save->composer = $composer;
        $save->save();

        session()->flash('success', 'File uploaded successfully!');


        return redirect('upload-file');
    }


    public function musicList()
    {
        $email = Session::get('email');
        $files = File::whereHas('user', function ($query) use ($email) {
            $query->where('email', $email);
        })
        ->orderBy('created_at', 'desc')
        ->get();

        return view('dashboard')->with('musics', $files);
        
    }

    public function deleteFile($request)
    {


        File::where('url', 'files/' . $request)->delete();

        $file = 'public/files/' . $request; // The name of the file to delete
        $path = Storage::path($file); // Get the full path to the file
        // var_dump($path);

        if (file_exists($path)) {
            unlink($path); // Delete the file
            return redirect('dashboard');
        } else {
            // Return an error response if the file does not exist
            return response()->json(['error' => 'File does not exist'], 404);
        }
    }

    public function YoutubeLink()
    {
        # code...
        return view('youtubeLink');
    }

    public function YoutubeStore(Request $request)
    {
        $request->validate([
            'link' => 'required|url',
        ], [
            'link.required' => 'Please enter a URL.',
        ]);


        $data = request()->all();

        // var_dump( $data['link'] );

        $parsedUrl = parse_url($data['link']);
        $baseUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];
        var_dump($baseUrl);

        $url = '';

        switch ($baseUrl) {
            case 'https://www.youtube.com':
                parse_str(parse_url($data['link'], PHP_URL_QUERY), $query);
                $url = $query === [] ? '' : $query['v'];
                break;
            case 'https://youtu.be':
                $url = str_replace('https://youtu.be/', '', $data['link']);
                break;

            default:
                return redirect('youtube-link')->withErrors(['youtubeLink' => 'Invalid URL']);
        }
        
        try {
            
                    $options = [
                        'headers' => [
                            'X-RapidAPI-Key' => '2fbb89fad7mshd0dd7a621d48316p1c052djsn5ccb558dcc70',
                            'X-RapidAPI-Host' => 'youtube-mp36.p.rapidapi.com'
                        ]
                    ];
            
                    $response = Http::withOptions($options)->get('https://youtube-mp36.p.rapidapi.com/dl', [
                        'id' => $url
                    ]);

        } catch (ConnectionException $e) {
            // handle connection error
            // for example, log the error and show a friendly error message to the user
            Log::error('Connection error: ' . $e->getMessage());
            return response()->view('errors.connection', [], 500);
        }


        $link = $response->json('link');
        $fileTitle = $response->json('title');
        // var_dump($link);

        // // Get the original file name and extension
        $fileName = 'my_file.mp3';
        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);

        // Generate a random string and append it to the file extension
        $randomString = Str::random(20);
        $newFileName = $randomString . '.' . $fileExt;


        $targetFolder = 'public/files';

        $client = new Client();
        $response = $client->get($link);

        Storage::put($targetFolder . '/' . $newFileName, $response->getBody());

        $path = storage_path('app/public/files/' . $newFileName);

        $track = new GetId3($path);

        $data = $track->extractInfo();
        // var_dump($data['comments']);

        $picture = $data['comments']['picture'][0]['data'];
        $mime = $data['comments']['picture'][0]['image_mime'];
        $encoded = base64_encode($picture);
        $src = "data:$mime;base64,$encoded";

        $title = $track->getTitle() ? $track->getTitle() : '';
        // var_dump($title);
        $artist = $track->getArtist() ? $track->getArtist() : '';
        // var_dump($track->getAlbum());
        $album = $track->getAlbum() ? $track->getAlbum() : '';
        // var_dump($track->getPlaytime());
        $playtime = $track->getPlaytime() ? $track->getPlaytime() : '';
        // var_dump($track->getPlaytimeSeconds());
        $genres = $track->getGenres() ? $track->getGenres() : '';
        // var_dump($genres[0]);

        $composer = $track->getComposer() ? $track->getComposer() : '';
        // var_dump($track->getComposer());

        $id = Session::get('id');

        $isFile = false;
        $isOffline = true;


        $fileType = str_replace('.', '', strrchr($newFileName, '.'));

        $save = new File;

        $save->user_id = $id;
        $save->fileName = $fileTitle;
        $save->fileType = $fileType;
        $save->url = 'files/' . $newFileName;
        $save->img = $src === NULL ? '' : $src;
        $save->title = $title;
        $save->artist = $artist;
        $save->album = $album;
        $save->playtime = $playtime;
        $save->genres = $genres === '' ? '' : $genres[0];
        $save->composer = $composer;
        $save->save();

        session()->flash('youtubeLink', $link);

        return redirect('youtube-link');
    }

    public function stream(Request $request, $file)
    {
        $path = storage_path('app/public/files/' . $file);
        $filesize = filesize($path);

        $headers = [
            'Content-Type' => 'audio/mpeg',
            'Content-Length' => $filesize,
            'Accept-Ranges' => 'bytes',
            'Cache-Control' => 'no-cache',
            'Content-Transfer-Encoding' => 'binary',
            'Connection' => 'keep-alive',
        ];

        $stream = new StreamedResponse(function () use ($path) {
            $handle = fopen($path, 'rb');
            fpassthru($handle);
            fclose($handle);
        }, 200, $headers);


        return $stream;
    }
}
