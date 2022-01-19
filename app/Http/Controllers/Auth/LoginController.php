<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginIndex()
    {
        return view('auth.login');
    }

    public function checkLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required | email', 
            'password' => 'required',
        ]);
        
        $credentials = $request->only('email', 'password');

        if(!Auth::attempt($credentials)){
            return redirect('login')->withErrors(['Invalid email or password!!!', ' Please check it']);
        }

        if (Auth::check()) {
            return redirect()->intended();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
