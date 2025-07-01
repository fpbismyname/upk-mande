<?php

namespace App\Http\Controllers;

use App\Helpers\Messages;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Hash;

class Auth extends Controller
{

    public static function loginPage()
    {
        return view('pages.auth.login');
    }
    public static function registerPage()
    {
        return view('pages.auth.register');
    }
    public static function login(Request $request)
    {
        $creds = $request->validate([
            'email' => 'required | email',
            'password' => 'required | min:6'
        ]);

        if (FacadesAuth::attempt($creds)) {
            $request->session()->regenerate();
            return redirect()->intended('/')->with(Messages::$login['success']);
        }

        return redirect()->back()->with(Messages::$login['failed'])->withInput();
    }
    public static function register(Request $request)
    {
        $creds = $request->validate([
            'name' => 'required',
            'email' => 'required | email  | unique:users,email',
            'password' => 'required | confirmed | min:6',
        ]);

        $creds['password'] = Hash::make($creds['password']);

        $user = User::create($creds);

        if ($user) {
            $credentials = [
                'email' => $request->email,
                'password' => $request->password,
            ];
            if (FacadesAuth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended('/')->with(Messages::$register['success']);
            }
        } else {
            return redirect()->back()->with(Messages::$register['failed'])->withInput();
        }
    }

    public static function logout()
    {
        FacadesAuth::logout();
        return redirect()->intended('/');
    }
}
