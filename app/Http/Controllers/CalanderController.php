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
                            'start' => $value->created_at,
                            'id'=>$order->id,
                            'route_id'=>$value->id
                        );
                    }
                }
            }

            return response()->json($testData);
        }
    }

    public function changeOrderDate(Request $request){
        $route = Routing::findOrFail($request->route_id);
        if($route){
            $orderIds = explode(',', $route->order_ids);
            $updatedOrderIds = array_diff($orderIds, [$request->order_id]);
            $updatedOrderIdsString = implode(',', $updatedOrderIds);
            $route->order_ids = $updatedOrderIdsString;
            $route->save();
            $order = Order::findOrFail($request->order_id);
            $order->delivery_date = $request->start;
            $order->save();
        }
        return response()->json([
            'success'=>true
        ], 200);
    }
}
