<?php

namespace App\Http\Controllers;

use App\Events\OrderCreated;
use App\Models\Order;
use App\Models\Routing;
use App\Models\TruckDriver;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CalanderController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->startDate ?? null;
        $endDate = $request->endDate ?? null;

        $weekNumber = 1;  // Change this to 2, 3, 4, etc. for different weeks

        if ($startDate && $endDate) {
            // Use the provided startDate and endDate for the week range
            $startOfWeek = Carbon::parse($startDate)->startOfWeek()->format('Y-m-d');
            $endOfWeek = Carbon::parse($endDate)->endOfWeek()->format('Y-m-d');
        } else {
            // Use the current week number logic as fallback
            $weekNumber = 1;  // Change this to 2, 3, 4, etc. for different weeks
            $startOfWeek = Carbon::now()->addWeeks($weekNumber - 1)->startOfWeek()->format('Y-m-d');
            $endOfWeek = Carbon::now()->addWeeks($weekNumber - 1)->endOfWeek()->format('Y-m-d');
        }

        $data = Routing::whereBetween('routing_date', [$startOfWeek, $endOfWeek])
            ->with('driver')->get();

        $dataByDay = $data->groupBy(function ($item) {
            return Carbon::parse($item->routing_date)->englishDayOfWeek;
        })->toArray();

        $dataGroupedByTruck = [];
        $englishDaysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        // Iterate over each truck's data
        foreach ($dataByDay as $day => $routes) {
            // Iterate over each route in the day's routes
            foreach ($routes as $route) {
                dd($route);
                // Get the truck_id for the current route
                $truckId = $route['driver']['truck_driver']['truck']['name'];

                // Use Carbon to get the day name in English
                $dayName = Carbon::parse($day)->isoFormat('dddd');

                // Check if the truck_id exists in the grouped array, if not, initialize it
                if (!isset($dataGroupedByTruck[$truckId])) {
                    $dataGroupedByTruck[$truckId] = [];
                }

                // Initialize each day for the current truck if not already initialized
                foreach ($englishDaysOfWeek as $dayOfWeek) {
                    if (!isset($dataGroupedByTruck[$truckId][$dayOfWeek])) {
                        $dataGroupedByTruck[$truckId][$dayOfWeek] = [];
                    }
                }

                // Add the route to the truck_id's day array
                $dataGroupedByTruck[$truckId][$dayName][] = $route;
            }
        }

        // Ensure all days have empty arrays for trucks with no data
        foreach ($dataGroupedByTruck as &$truckData) {
            foreach ($englishDaysOfWeek as $dayOfWeek) {
                if (!isset($truckData[$dayOfWeek])) {
                    $truckData[$dayOfWeek] = [];
                }
            }
        }



        // dd($dataGroupedByTruck);


        return view('calander.index', compact('dataGroupedByTruck'));
    }

    public function viewForOrderCalander()
    {
        return view('calander.order_calander');
    }

    public function viewForSwapCalander()
    {
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

    public function swapOrdersCalander(Request $request)
    {
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
                    'route_name' => $route->route_name,
                    'order_ids' => $request->order_id,
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
