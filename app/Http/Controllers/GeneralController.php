<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Routing;
use App\Models\Trailers;
use App\Models\TrailerSwapOrder;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function trailerSwapReport(Request $request)
    {
        $graded = [];
        $notGraded = [];
        // if ($request->date) {
        //     $orders = Order::whereDate('created_at', $request->date)->where('load_type', 'trailer_swap')->with(['trailerSwapOrder', 'customer'])->get();
        // } else {
        //     $orders = Order::where('load_type', 'trailer_swap')->with(['trailerSwapOrder', 'customer'])->get();

        // }
        $orders = Order::where('load_type', 'trailer_swap')->with(['trailerSwapOrder', 'customer'])->get();

        foreach ($orders as $order) {
            if ($order->customer->trailer_grading_type == 'trailers_to_grade') {
                $graded[] = $order;
            } else if ($order->customer->trailer_grading_type == 'trailers_green_light') {
                $notGraded[] = $order;
            }
        }

        $customers = Customer::select('id', 'business_name')->get();
        $trailers = Trailers::all();
        return view('reports.trailer', compact('graded', 'notGraded', 'customers','trailers'));

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
        $trailers = TrailerSwapOrder::where('trailer_drop_off', $trailerNo)->with('order')->latest()->first();
        return view('trailer.search', compact('trailers'));


    }

    public function updateTrailerData(Request $request){
        $trailerId = $request->trailer_id;
        // $trailerData = TrailerSwapOrder::findOrFail($trailerId);
        // if($trailerData){
        //     $trailerData->status = $request->statusData;
        //     $trailerData->location = $request->location;
        //     $trailerData->update();
        // }

        $trailer = Trailers::find($trailerId);
        if($trailer){
            $trailer->status  = $request->status;
            $trailer->location = $request->location;
            $trailer->save();
        }

        return back()->with('success', 'Data updated successfully' );
    }

}
