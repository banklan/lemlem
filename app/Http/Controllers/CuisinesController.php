<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cuisine;
use App\Category;

class CuisinesController extends Controller
{
    public function fetchMeals($id)
    {
        $meals = Cuisine::where('restaurant_id', $id)->get();

        return response()->json($meals, 200);
    }

    public function fetchAll()
    {
        $cuisines = Cuisine::all();

        return response()->json($cuisines, 200);
    }

    public function fetchCats()
    {
        $cats = Category::orderBy('name', 'asc')->get();

        return response()->json($cats, 201);
    }

    public function fetchCarouselImgs()
    {
        $imgs = Cuisine::where('id', '<', '4')->get();

        return response()->json($imgs, 200);
    }

    public function fetchPopCuisines()
    {
        //change later to popular order
        $pop = Cuisine::orderBy('id')->limit(3)->get();

        return response()->json($pop, 200);
    }

    public function search(Request $request)
    {
        // print_r($request->q);
        $this->validate($request, [
            'q' => 'required'
        ]);
        
        $q = $request->q;
        $cuisines = Cuisine::where('name', 'LIKE', "%".$q."%")
                    ->orWhereHas('category', function($x) use($q){
                        $x->where('name', 'LIKE', "%".$q."%");
                    })
                    ->orWhereHas('restaurant', function($x) use($q){
                        $x->where('name', 'Like', "%".$q."%");
                    })
                    ->get();

        return response()->json($cuisines, 200);
    }

    public function getCuisineById($id)
    {
        $cuisine = Cuisine::findOrFail($id);

        return response()->json($cuisine, 200);
    }

    public function fetchSimilarCuis($id)
    {
        $cuis = Cuisine::where('category_id', $id)->get();

        return response()->json($cuis, 200);
    }

    public function fetchCuisFromSameIutlets($id)
    {
        $cuis = Cuisine::where('restaurant_id', $id)->limit(3)->get();

        return response()->json($cuis, 200);
    }
}
