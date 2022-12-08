<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function getLogin(){
        if (Auth::guard('web')->check()) {
            return redirect('/');
        } else {
            return view('pages.login');
        }
    }

    public function postLogin(LoginRequest $request) {
        $login = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::guard('web')->attempt($login)) {
            return redirect('/');
        } else {
            return redirect()->back()->with('status', 'Username Or Password Is Incorrect');
        }
    }

    public function getLogout()
    {
        Auth::guard('web')->logout();
        return redirect('/login');
    }
}
