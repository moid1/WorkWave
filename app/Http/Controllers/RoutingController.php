<?php

namespace App\Http\Controllers;

use App\Events\RouteCreated;
use App\Models\Order;
use App\Models\Routing;
use App\Models\Truck;
use App\Models\TruckDriver;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoutingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $allRoutes = Routing::all();
            return response()->json([
                'success' => true,
                'data' => $allRoutes,
                'message' => 'All Routes'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getRoutes()
    {
        $allRoutes = Routing::with('driver')->get();
        return view('routing.index', compact('allRoutes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            $this->validate($request, [
                'order_ids' => ['required', 'string', 'max:255'],
                'route_name' => ['required'],
                'driver_id' => ['required']
            ]);

            $routing = Routing::create($request->all());

            event(new RouteCreated());

            return response()->json([
                'success' => true,
                'data' => $routing,
                'message' => 'Route has been created successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function createWebRoute(Request $request)
{
    // Validate the request
    $request->validate([
        'order_ids' => ['required', 'string', 'max:255'],
        'route_name' => ['required', 'string', 'max:255'],
        'truck_id' => ['required', 'integer'],
        'routing_date' => ['required', 'date'],
        'exceeding_order' => ['sometimes', 'string'],
        'simpleOrderObjects' => ['sometimes'],
        'exceedingOrderObjects' => ['sometimes'],
    ]);

    try {
        // Begin a database transaction
        DB::beginTransaction();

        $simpleOrders = $request->order_ids;
        $exceedingOrders = $request->exceeding_order ?? '';
        $simpleOrderObjects = $request->simpleOrderObjects ?? [];
        $exceedingOrderObjects = $request->exceedingOrderObjects ?? [];

        $simpleOrderIds = explode(',', $simpleOrders);
        $exceedingOrderIds = explode(',', $exceedingOrders);
        // Get same Orders
        $sameOrderIds = array_intersect($simpleOrderIds, $exceedingOrderIds);

        $today = date('Y-m-d');
        // Calculate next day date
        $nextDayDate = date('Y-m-d', strtotime($today . ' +1 day'));
        $newOrderIds = [];

        foreach ($exceedingOrderObjects as $key => $exceedingOrderObject) {
            if (!in_array($exceedingOrderObject['orderId'], $sameOrderIds)) {
                continue;
            }

            $order = Order::find($exceedingOrderObject['orderId']);
            $newOrder = Order::create([
                'customer_id' => $order['customer_id'],
                'user_id' => Auth::id(),
                'notes' => 'Left Over Tires Order',
                'load_type' => $order['load_type'],
                'truck_id' => $order['truck_id'],
                'delivery_date' => $nextDayDate,
                'end_date' => $nextDayDate,
                'estimated_tires' => $exceedingOrderObject['estimatedTires']
            ]);

            $newOrderIds[] = $newOrder->id;
        }

        // Create a new routing entry
        $routing = Routing::create([
            'order_ids' => $request->order_ids,
            'route_name' => $request->route_name,
            'truck_id' => $request->truck_id,
            'routing_date' => $request->routing_date
        ]);

        // Extract order IDs from comma-separated string
        $orderIDs = explode(',', $request->order_ids);

        // Update all orders to mark them as routed
        Order::whereIn('id', $orderIDs)->update(['is_routed' => true]);

        if (count($exceedingOrderIds) > 0) {
            $exceedsOrders = Order::whereIn('id', $exceedingOrderIds)->get();
            $routes = [];
            $currentRoute = [];
            $totalTires = 0;

            foreach ($exceedsOrders as $order) {
                $orderTires = $order->estimated_tires;

                if ($totalTires + $orderTires <= 400) {
                    $currentRoute[] = $order;
                    $totalTires += $orderTires;
                } else {
                    $routes[] = $currentRoute; // Save the current route
                    $currentRoute = [$order]; // Start a new route with the current order
                    $totalTires = $orderTires;
                }
            }

            // Handle remaining orders in currentRoute
            if (!empty($currentRoute)) {
                $routes[] = $currentRoute;
            }

            $routingDate = Carbon::parse($request->routing_date);

            foreach ($routes as $index => $routeOrders) {
                $totalTires = 0;
                $routeOrderIds = [];

                foreach ($routeOrders as $order) {
                    $orderTires = $order->estimated_tires;

                    if ($totalTires + $orderTires <= 400) {
                        $routeOrderIds[] = $order->id;
                        $totalTires += $orderTires;
                    } else {
                        // Create a route with current orders
                        $this->createRoutingEntry($routeOrderIds, $request->route_name, $request->truck_id, $routingDate, $index);
                        // Start a new route with the current order
                        $routeOrderIds = [$order->id];
                        $totalTires = $orderTires;
                        $index++;
                    }
                }

                if (!empty($routeOrderIds)) {
                    $this->createRoutingEntry($routeOrderIds, $request->route_name, $request->truck_id, $routingDate, $index);
                }

                $routingDate = $this->getNextBusinessDay($routingDate);
            }
        }

        // Commit the transaction
        DB::commit();

        // Trigger event for route creation
        event(new RouteCreated());

        // Return success response
        return response()->json([
            'success' => true,
            'data' => $routing,
            'message' => 'Route has been created successfully'
        ]);
    } catch (\Exception $e) {
        // Roll back the transaction in case of failure
        DB::rollBack();

        // Log the exception
        Log::error('Error creating route: ' . $e->getMessage(), ['exception' => $e]);

        // Return error response
        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

private function createRoutingEntry($orderIds, $routeName, $truckId, $routingDate, $index)
{
    Routing::create([
        'order_ids' => implode(',', $orderIds),
        'route_name' => $routeName . ' (Exceeding Date Route ' . ($index + 1) . ')',
        'truck_id' => $truckId,
        'routing_date' => $routingDate
    ]);

    Order::whereIn('id', $orderIds)->update(['is_routed' => true]);
}

private function getNextBusinessDay($date)
{
    $date = Carbon::parse($date);

    $nextBusinessDay = $date->copy();

    do {
        $nextBusinessDay->addDay();
    } while ($nextBusinessDay->isWeekend());

    return $nextBusinessDay->format('Y-m-d');
}
    /**
     * Display the specified resource.
     */
    public function show(Routing $routing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Routing $routing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Routing $routing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Routing $routing)
    {
        //
    }

    public function getNotStartedRouteGroups()
    {

        try {
            $routes = Routing::where('driver_id', Auth::id())->where('is_route_started', false)->get();
            return response()->json([
                'success' => true,
                'data' => $routes,
                'message' => 'All routes group which not started'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getRoutesById($id)
    {
        try {
            $route = Routing::find($id);
            if ($route) {
                $orderIdsArray = $route->order_ids ? explode(',', $route->order_ids) : [];
                $orders = Order::whereIn('id', $orderIdsArray)->with('customer')->get();
                return response()->json([
                    'success' => true,
                    'data' => $orders,
                    'message' => 'all orders'
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'data' => [],
                    'message' => 'Unable to find order'
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function deleteRoute($id)
    {
        try {
            Routing::find($id)->delete();
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function deleteRouteWeb($id)
    {
        Routing::find($id)->delete();
        return back()->with('success', 'Route is deleted successfully');
    }

    public function createRouting()
    {
        $drivers = User::where('type', 2)->get();
        $trucks = Truck::where('is_active', true)->get();
        return view('routing.create', compact('drivers', 'trucks'));
    }

    public function getDriverOrderRouting(Request $request)
    {

        $data = Order::where('truck_id', $request->truck_id)
            ->where('is_routed', false)
            ->with(['customer', 'user', 'driver']);

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $fromDate = Carbon::parse($request->from_date);
            $toDate = Carbon::parse($request->to_date)->endOfDay();
            $data->where(function ($query) use ($fromDate, $toDate) {
                $query->whereBetween('delivery_date', [$fromDate, $toDate])
                    ->orWhereBetween('end_date', [$fromDate, $toDate]);
            });
        }
        // $data->limit(20); // Add this line to limit the number of results to 20

        $dataArray = $data->get();

        return response()->json($dataArray);
    }

    public function checkOrderDragging(Request $request)
    {
        $orderId = $request->order_id;
        $futureDay = $request->futureDay;
        $routing = Routing::whereRaw("FIND_IN_SET(?, order_ids)", [$orderId])->first();

        if ($routing) {

            $truckDriver = TruckDriver::where('user_id', $routing->driver_id)->latest()->first();

            // Step 3a: Remove orderId from existing routing
            $orderIds = explode(',', $routing->order_ids);
            $orderIds = array_diff($orderIds, [$orderId]);
            $routing->order_ids = implode(',', $orderIds);

            // Step 3b: Check availability on the specific day of the current week
            $currentWeekStart = Carbon::now()->startOfWeek();
            $currentWeekEnd = Carbon::now()->endOfWeek();

            // Find the date of the specific futureDay within the current week
            $futureDate = $this->getNextWeekdayDate($futureDay);


            // Save the updated routing
            $routing->save();

            $newRouting = Routing::create([
                'order_ids' => $request->order_id,
                'route_name' => $request->route_name,
                'driver_id' => $truckDriver->user_id,
                'routing_date' => $futureDate
            ]);

            // Extract order IDs from comma-separated string
            // $orderIDs = explode(',', $request->order_ids);

            // Update all orders to mark them as routed
            // Order::whereIn('id', $orderIDs)->update(['is_routed' => true]);

            if (empty($routing->order_ids)) {
                $routing->delete();
            }
            return response()->json();

        } else {
            // Handle case where no existing routing found (possibly create a new route)
            // Example:
            // $newRouting = new Routing();
            // $newRouting->order_ids = $orderId;
            // $newRouting->save();
        }


    }

    /**
     * Get the date of the next occurrence of a specific weekday in the current week.
     *
     * @param string $dayOfWeek The name of the day of the week (e.g., "Monday", "Tuesday").
     * @return \Carbon\Carbon|null The Carbon date object representing the next occurrence of the specified day, or null if invalid day.
     */
    private function getNextWeekdayDate($dayOfWeek)
    {
        $now = Carbon::now();
        $currentDayOfWeek = strtolower($now->englishDayOfWeek);

        // Calculate the difference in days between current day and the target day
        $daysToAdd = array_search(($dayOfWeek), Carbon::getDays());


        if ($daysToAdd === false) {
            return null; // Invalid day of the week
        }

        $futureDate = $now->addDays($daysToAdd);
        return $futureDate->startOfDay();
    }

}
