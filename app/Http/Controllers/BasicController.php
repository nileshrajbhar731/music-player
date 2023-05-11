<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;

class BasicController extends Controller
{
   public function login()
   {
      return view('login');
   }
   public function auth(Request $request)
   { {
         $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
         ]);

         $credentials = $request->only('email', 'password');
         // var_dump(Auth::attempt($credentials));
         if (Auth::attempt($credentials)) {
            $user = User::where('email', $credentials['email'])->first();
            var_dump($user);
            Session::put('id', $user->id);
            Session::put('avatar', $user->avatar);
            Session::put('name', $user->name);
            Session::put('email', $user->email);
            Session::put('email_verified', $user->verified_email);
            return redirect()->intended('dashboard')
               ->withSuccess('You have Successfully loggedin');
         }

         // return redirect("login")->withSuccess('Oppes! You have entered invalid credentials');
      }
   }
   public function signin()
   {
      return view('signIn');
   }
   public function store(Request $request)
   {
      $data = request()->all();
      $request->validate([
         'fn' => 'required',
         'email' => 'required|email',
         'password' => 'required|min:8|confirmed',
         'password_confirmation' => 'required|min:8',
      ], [
            'fn.required' => 'Enter the full name',
            'email.required' => 'Enter the email',
            'email.email' => 'Enter the valid email address.',
            'password.required' => 'Enter the password',
            'password_confirmation.required' => 'Enter the password confirmation',
         ]);

      $finduser = User::where('email', $data['email'])->first();

      if ($finduser) {
         session()->flash('error', 'Email alreday Exits!');
         return redirect()->intended('signin');
      } else {
         User::create([
            'google_account' => '0',
            'name' => $data['fn'],
            'avatar' => "",
            'email' => $data['email'],
            'email_verified' => "0",
            'password' => Hash::make($data['password']),
            'remember_token' => $data['_token'],
         ]);
      }

   }
}