<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;


class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }
    public function actionLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $credential = $request->only('email', 'password');
        // Auth : class dari laravel
        if (Auth::attempt($credential)) {
            Alert::success('success', 'Success Login');

            return redirect('dashboard')->with('success', 'Success Login');
        } else {


            return back()->with('error', 'Email/Password Incorrect');
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect("login");
    }
}
