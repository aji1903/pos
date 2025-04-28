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
            $level_user = Auth::user()->level_id;

            if ($level_user == 1) {
                Alert::success('success', 'Cashier Success Login');
                return redirect('dashboard')->with('success', 'Cashier Success Login');
            } elseif ($level_user == 2) {
                Alert::success('success', 'Leader Success Login');
                return redirect('dashboard')->with('success', 'Leader Success Login');
            } elseif ($level_user == 3) {
                Alert::success('success', 'Admin Success Login');
                return redirect('dashboard')->with('success', 'Admin Success Login');
            }
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
