<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Restaurant;

class OutletsController extends Controller
{
    public function fetchAllOutlets()
    {
        $outlets = Restaurant::orderBy('name')->get();

        return response()->json($outlets, 200);
    }

    public function fetchOutlet($id)
    {
        $outlet = Restaurant::findOrFail($id);

        return response()->json($outlet->load(['cuisine', 'cuisine_review']), 200);
    }
}
