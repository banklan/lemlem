<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BearerLoginController extends Controller
{
    public function __construct(){
        $this->middleware('guest:bearer', ['except' => ['logout']]);
    }

    public function showLoginForm()
    {
        return view('auth.bearer-login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if(Auth::guard('bearer')->attempt($credentials, $request->remember)){ 
            return redirect()->intended(route('bearer.home'));
        }
           return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function logout(Request $request)
    {
        Auth::guard('bearer')->logout();

        return redirect('/bearer/login');
    }
}
