<?php

namespace App\Http\Controllers;


use App\Models\User;
use Exception;
use Auth;
use Laravel\Socialite\Facades\Socialite;
use Session;
use Illuminate\Http\Request;


class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();

            $finduser = User::where('email', $user->email)->first();
            $verified_email = $user->user['verified_email'];
            // var_dump($verified_email);
            if ($finduser) {
                Auth::login($finduser);
                Session::put('avatar', $user->avatar);
                Session::put('name', $user->name);
                Session::put('email', $user->email);
                Session::put('email_verified', $user->verified_email);
                Session::put('id', $finduser->id);
                return redirect()->intended('/dashboard');
            } else {
                $newUser = User::create([
                    'google_account' => '1',
                    'name' => $user->name,
                    'avatar' => $user->avatar,
                    'email' => $user->email,
                    'email_verified' => $verified_email,
                    'password' => "",
                    'remember_token' => $user->token,
                ]);

                
                Session::put('avatar', $user->avatar);
                Session::put('name', $user->name);
                Session::put('email', $user->email);
                Session::put('email_verified', $user->verified_email);
                Session::put('id', $finduser->id);

                // var_dump($newUser);

                Auth::login($newUser);
                return redirect()->intended('/dashboard');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        $request->session()->forget('avatar');
        $request->session()->forget('name');
        $request->session()->forget('email');
        $request->session()->forget('email_verified');
        return redirect('/login');
    }

    // profile view
    public function Profile()
    {
        return view('profile');

    }





}