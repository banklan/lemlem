<?php

namespace App\Http\Controllers;

use App\City;
use App\Location;
use App\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CityController extends Controller
{
    public function getCities()
    {
        $cities = City::orderBy('name')->get();

        return response()->json($cities, 200);
    }

    public function fetchOutlets($id)
    {
        $outlets = Restaurant::where('city_id', $id)->get();

        return response()->json($outlets, 200);
    }

    public function fetchLocations($id)
    {
        $locations = Location::where('city_id', $id)->orderBy('name')->get();

        return response()->json($locations, 200);
    }

    public function fetchUserLoc()
    {
        $user = Auth::user()->location_id;

        return response()->json($user, 200);
    }
}
