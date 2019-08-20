<?php

namespace App\Http\Controllers;

use App\Order;
use App\Charges;
use Carbon\Carbon;
use App\OrderSummary;
use App\Mail\OrderReceived;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index()
    {
        return view('orders');
    }

    public function calc()
    {
        //generate randowm strings and concat with date for a unique order_id
        $year= Carbon::now()->format('y');
        $month = Carbon::now()->format('m');
        $day = Carbon::now()->format('d');
        $rand = substr(sha1(mt_rand()), 17, 6);
        $calc = $day.$month.$year.$rand;

        print_r($calc);
    }

    public function send(Request $request)
    {
        $orders = $request->orders;
        $year= Carbon::now()->format('y');
        $month = Carbon::now()->format('m');
        $day = Carbon::now()->format('j');
        $rand = substr(sha1(mt_rand()), 17, 6);
        $orderId = $day.$month.$year.$rand;

        for($i=0; $i < count($orders); $i++){
           $order = new Order;
           $order->order_no = $orderId;
           $order->user_id = Auth::id();
           $order->cuisine_id = $orders[$i]['id'];
           $order->units = $orders[$i]['portion'];

           $order->save();
        }

        $this->validate($request, [
            'instr' => 'max:200',
            'pymt_status' => 'required'
        ]);

        //create order summary
        $summary = new OrderSummary;
        $summary->order_id = $orderId;
        $summary->user_id =  Auth::id();
        $summary->item_count = count($orders);
        $summary->total = $request->tot;
        $summary->instruction = $request->instr;
        $summary->pymt_status = $request->pymt_status;
        $summary->save();

         //store charges
         $charges = new Charges;
         $charges->amount = $request->charges;
         $charges->user_id = Auth::id();
         $charges->order_no = $orderId;
         
         $charges->save();

        return response()->json($summary, 200);
    }

    public function sendOrderRcvdMail(Request $request)
    {
        $order = OrderSummary::findOrFail($request->order);
        $user = Auth::user();
        Mail::to($user->email)->send(new OrderReceived($user, $order));
    }

    public function fetchMyOrders()
    {
        $me = Auth::id();

        $orders = OrderSummary::where('user_id', $me)->latest()->get();
        return response()->json($orders, 200);
    }

    public function fetchSingleOrder($id)
    {
        $order = Order::where('order_no', $id)->get();
        
        return response()->json($order->load(['cuisine', 'restaurant']), 200);
    }

    public function fetchOrderSummary($id)
    {
        $summary = OrderSummary::where('order_id', $id)->first();

        return response()->json($summary, 200);
    }

    public function fetchOrderSummaryForUser()
    {
        $me = Auth::id();
        $summaries = OrderSummary::where('user_id', $me)->get();

        return response()->json($summaries, 200);
    }
}
