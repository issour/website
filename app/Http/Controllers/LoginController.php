<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /**
      * Redirect the user to the GitHub authentication page.
      *
      * @return \Illuminate\Http\Response
      */
    public function redirect()
    {
        return Socialite::driver('github')->stateless()->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function callback()
    {
        try {
            $user = Socialite::driver('github')->stateless()->user();
        } catch (\Exception $e) {
            return redirect()->route('login.github');
        }

        $user = User::firstOrCreate(['email' => $user->email ], [
            'name' => $user->name,
            'email' => $user->email,
            'github' => $user->nickname,
            'password' => Str::random(),
        ]);

        Auth::login($user);

        return back();
    }
}
