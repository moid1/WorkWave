<?php

namespace App\Http\Controllers;

use App\Events\OrderCreated;
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

    public function viewForOrderCalander()
    {
        return view('calander.order_calander');
    }

    public function viewForSwapCalander(){
        return view('calander.swap_calander');
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
                            'start' => $order->delivery_date,
                            'id' => $order->id,
                            'route_id' => $value->id
                        );
                    }
                }
            }

            return response()->json($testData);
        }
    }

    public function ordersForCalander(Request $request)
    {
        if ($request->ajax()) {
            $orders = Order::whereDate('created_at', '>=', $request->start)->get();
            $testData = array();
            foreach ($orders as $key => $order) {
                $testData[] = array(
                    'title' => $order->customer->business_name,
                    'start' => $order->delivery_date,
                    'id' => $order->id,
                    'color' => 'red'
                );
            }

            return response()->json($testData);
        }
    }

    public function swapOrdersCalander(Request $request){
        if ($request->ajax()) {
            $orders = Order::where('load_type', 'trailer_swap')->whereDate('created_at', '>=', $request->start)->get();
            $testData = array();
            foreach ($orders as $key => $order) {
                $testData[] = array(
                    'title' => $order->customer->business_name,
                    'start' => $order->delivery_date,
                    'id' => $order->id,
                );
            }

            return response()->json($testData);
        }
    }

    public function changeOrderDate(Request $request)
    {
        if ($request->has('onlyOrder') && $request->onlyOrder) {
            $order = Order::findOrFail($request->order_id);
            $order->delivery_date = $request->start;
            $order->save();
        } else {
            $route = Routing::findOrFail($request->route_id);
            if ($route) {
                $orderIds = explode(',', $route->order_ids);
                $order = Order::findOrFail($request->order_id);
                $order->delivery_date = $request->start;
                $order->save();
                    $updatedOrderIds = array_diff($orderIds, [$request->order_id]);
                    $updatedOrderIdsString = implode(',', $updatedOrderIds);
                    $route->order_ids = $updatedOrderIdsString;
                    $route->save();

                    Routing::create([
                        'route_name'=>$route->route_name,
                        'order_ids'=>$request->order_id,
                        'driver_id' => $route->driver_id,
                    ]);
                


            }
        }

        event(new OrderCreated($order));

        return response()->json([
            'success' => true
        ], 200);
    }
}
