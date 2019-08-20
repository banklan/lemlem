<?php

namespace App\Http\Controllers;

use App\Order;
use App\Rating;
use App\OrderSummary;
use App\CuisineReview;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth')->except(['fetchCuisReviews', 'fetchRatings']);
    }

    public function checkCuisReview($order)
    {
        $me = Auth::id();
        $check = CuisineReview::where(['user_id' => $me, 'order_id' => $order])->first();
        if($check){
            return response()->json(true, 200);
        }
            return response()->json(false, 200);
    }

    public function sendValetReview(Request $request, $order)
    {
        $user = Auth::id();

        $this->validate($request, [
            'comment' => 'required|max:200'
        ]);

        $order = OrderSummary::where(['user_id' => $user, 'order_id' => $order])->first();

        $order->update([
            $order->valet_review = $request->comment
        ]);

        return response()->json($order, 200);
    }

    public function sendOrderReview(Request $request, $id)
    {
        $this->validate($request, [
            'comment' => 'required|max:200'
        ]);

        $order_no = $request->order['order_no'];
        $user = Auth::id();

        $order = Order::where(['order_no' => $order_no, 'user_id' => $user, 'cuisine_id' => $id])->first();
        
        // save ratings 
        $rest = $request->rest;
        $ratings = $request->rating;

        $rating = new Rating;
        $rating->user_id = $user;
        $rating->order_no = $order_no;
        $rating->cuisine_id = $id;
        $rating->restaurant_id = $rest;
        $rating->ratings = $ratings;

        $rating->save();

        //update the order
        $order->update([
            $order->review = $request->comment
        ]);

        //create new review
        $review = new CuisineReview;
        $review->user_id = $user;
        $review->order_id = $order_no;
        $review->cuisine_id = $id;
        $review->restaurant_id = $request->rest;
        $review->comments = $request->comment;
        $review->save();

        return Response()->json($review, 200);
    }

    public function fetchCuisReviews($id)
    {
        $reviews = CuisineReview::where('cuisine_id', $id)->latest()->get();

        return response()->json($reviews->load('user'), 200);
    }

    public function fetchRatings($id)
    {
        $ratings = Rating::where('restaurant_id', $id)->get();

        return response()->json($ratings, 200);
    }

    public function showReviewModal()
    {
        $user = Auth::id();
        
        $delOrders = OrderSummary::where(['user_id' => $user, 'status' => 'delivered'])->first();
        $orderNo = $delOrders->order_id;

        $order = Order::where(['user_id' => $user, 'order_no' => $orderNo])->inRandomOrder()->first();

        return response()->json($order->load('cuisine'), 200);
    }
}
