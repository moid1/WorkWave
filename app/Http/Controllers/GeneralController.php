<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Routing;
use App\Models\TrailerSwapOrder;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function trailerSwapReport(Request $request)
    {
        $graded = [];
        $notGraded = [];
        if ($request->date) {
            $orders = Order::whereDate('created_at', $request->date)->where('load_type', 'trailer_swap')->with(['trailerSwapOrder', 'customer'])->get();
        } else {
            $orders = Order::where('load_type', 'trailer_swap')->with(['trailerSwapOrder', 'customer'])->get();

        }
        foreach ($orders as $order) {
            if ($order->customer->trailer_grading_type == 'trailers_to_grade') {
                $graded[] = $order;
            } else if ($order->customer->trailer_grading_type == 'trailers_green_light') {
                $notGraded[] = $order;
            }
        }
        return view('reports.trailer', compact('graded', 'notGraded'));

    }

    public function getOrdersByTruckRouted(Request $request)
    {
        $driver_id = $request->driver_id;
        if (!$driver_id) {
            return;
        }

        $routing = Routing::where('driver_id', $driver_id)->latest()->first();
        if ($routing) {
            $orderIds = explode(',', $routing->order_ids);

            // Fetch orders from database
            $orders = Order::whereIn('id', $orderIds)->with('customer')->get();
            return view('truck.orders', compact('orders'));

        }
    }

    public function getSearachTrailerView(){
        $trailers = [];
        return view('trailer.search', compact('trailers'));
    }

    public function getSearchTrailerData(Request $request){
        $trailerNo = $request->trailer_no;
        $trailers = TrailerSwapOrder::where('trailer_pick_up', $trailerNo)->orWhere('trailer_drop_off', $trailerNo)->with('order')->get();
        return view('trailer.search', compact('trailers'));


    }
}
