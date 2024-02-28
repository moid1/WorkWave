<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Routing;
use App\Models\TruckDriver;
use Illuminate\Http\Request;

class CalanderController extends Controller
{
    public function index()
    {
        return view('calander.index');
    }

    public function eventsForCalander(Request $request)
    {
        if ($request->ajax()) {
            $data = Routing::whereDate('created_at', '>=', $request->start)->get();
            $testData = array();
            foreach ($data as $key => $value) {
                $orderIdsArray = $value->order_ids ? explode(',', $value->order_ids) : [];
                $orders = Order::whereIn('id', $orderIdsArray)->with('customer')->get();
                foreach ($orders as $key => $order) {
                    $truck = TruckDriver::whereUserId($order->driver_id)->with('truck')->first();
                    if ($truck) {
                        $testData[] = array(
                            'title' => $order->customer->business_name . '-' . $truck->truck->name,
                            'start' => $value->created_at
                        );
                    }
                }
            }

            return response()->json($testData);
        }
    }
}
