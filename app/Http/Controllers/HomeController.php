<?php

namespace App\Http\Controllers;

use Hamcrest\Core\IsNot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function checkUserLoc()
    {
        $me = Auth::user();
        if($me->location_id == null){
            return response()->json(false, 200);
        }else{
            return response()->json(true, 200);
        }
    }

    public function saveUserLocation(Request $request)
    {
        $user = Auth::user();
        $user->update([
            $user->location_id = $request->location
        ]);

        return response()->json(['message'=>'Location saved', 200]);
    }
}
