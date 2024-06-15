<?php

namespace App\Http\Controllers;

use App\Models\Order;
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
}
