<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BearerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:bearer');
    }

    public function index()
    {
        return view('bearer.home');
    }
}
