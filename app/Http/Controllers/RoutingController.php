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
        $allRoutes = Routing::with('truck')->get();
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
            \Log::error('Error creating route: ' . $e->getMessage(), ['exception' => $e]);

            // Return error response
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
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
            $trucDriver = TruckDriver::where('user_id', Auth::id())->with('truck')->latest()->first();
            if ($trucDriver && $trucDriver->truck) {
                $routes = Routing::where('truck_id', $trucDriver->truck->id)->where('is_route_started', false)->get();
                return response()->json([
                    'success' => true,
                    'data' => $routes,
                    'message' => 'All routes group which not started'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => "No truck is assigned to you"
                ], 500);
            }
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
            // Find the routing or fail if not found
            $routing = Routing::findOrFail($id);
            $orderIds = array_map('trim', explode(',', $routing->order_ids));


            // Perform the update operation
            Order::whereIn('order_id', $orderIds)
                ->update(['is_routed' => false]);

            // Return a successful response
            return response()->json([
                'status' => true,
                'message' => 'Route deleted successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function deleteRouteWeb($id)
    {
        try {
            // Find the routing or fail if not found
            $routing = Routing::findOrFail($id);
            $orderIds = array_map('trim', explode(',', $routing->order_ids));


            // Perform the update operation
            Order::whereIn('id', $orderIds)
                ->update(['is_routed' => false]);
            $routing->delete();

            return back()->with('success', 'Route is deleted successfully');
        } catch (\Throwable $th) {
            return back()->with('error', 'Route not found');
        }
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
            $fromDate = Carbon::parse($request->from_date)->startOfDay()->format('Y-m-d');
            $toDate = Carbon::parse($request->to_date)->endOfDay()->format('Y-m-d');

            $data->where(function ($query) use ($fromDate, $toDate) {
                $query->whereBetween('delivery_date', [$fromDate, $toDate])
                    ->orWhereBetween('end_date', [$fromDate, $toDate]);
            });
        }

        // Execute the query (if needed)
        $results = $data->get();

        return response()->json($results);
    }

    public function checkOrderDragging(Request $request)
    {
        $orderId = $request->order_id;
        $futureDay = $request->futureDay;
        $routing = Routing::whereRaw("FIND_IN_SET(?, order_ids)", [$orderId])->first();
        $truckSource = $request->sourceTruck;
        $truckDestination = $request->destinationTruck;
        $destinationRouteId = $request->destinationRouteId;
        if ($routing) {

            if (($request->sourceTruck) == $request->destinationTruckId) {

                $truckDriver = TruckDriver::where('user_id', $routing->driver_id)->latest()->first();

                // Step 3a: Remove orderId from existing routing
                $orderIds = explode(',', $routing->order_ids);
                $orderIds = array_diff($orderIds, [$orderId]);
                $routing->order_ids = implode(',', $orderIds);

                // Step 3b: Check availability on the specific day of the current week
                $currentWeekStart = Carbon::now()->startOfWeek();
                $currentWeekEnd = Carbon::now()->endOfWeek();

                // Find the date of the specific futureDay within the current week
                $futureDate = $this->getNextWeekdayDate(dayOfWeek: $futureDay);


                // Save the updated routing
                $routing->save();

                $newRouting = Routing::create([
                    'order_ids' => $request->order_id,
                    'route_name' => $routing->route_name,
                    'truck_id' => $routing->truck_id,
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

                // Step 3a: Remove orderId from existing routing
                $orderIds = explode(',', $routing->order_ids);
                $orderIds = array_diff($orderIds, [$orderId]);
                $routing->order_ids = implode(',', $orderIds);
                $routing->save();

                if (empty($routing->order_ids)) {
                    $routing->delete();
                }

                // source and destination trucks are different
                $destinationRouting = Routing::find($destinationRouteId);
                if (!$destinationRouting) {
                    $newRouting = Routing::create([
                        'order_ids' => $orderId,
                        'route_name' => 'New Route by Dropping',
                        'truck_id' => $truckDestination,
                        'routing_date' => $this->getWeekdayDate($futureDay)
                    ]);
                }

            }

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
        if ($daysToAdd) {
            $futureDate = $now->addDays($daysToAdd - 1);
            return $futureDate->startOfDay();
        }
    }

    public function getWeekdayDate(string $dayName): string
{
    // Define an array mapping day names to Carbon day of the week constants
    $daysOfWeek = [
        'sunday' => 0,
        'monday' => 1,
        'tuesday' => 2,
        'wednesday' => 3,
        'thursday' => 4,
        'friday' => 5,
        'saturday' => 6,
    ];

    // Normalize the input to lowercase
    $dayName = strtolower($dayName);

    // Check if the day name is valid
    if (!array_key_exists($dayName, $daysOfWeek)) {
        throw new InvalidArgumentException('Invalid day name. Please use Sunday, Monday, Tuesday, Wednesday, Thursday, Friday, or Saturday.');
    }

    // Get the current date
    $currentDate = Carbon::now();

    // Find the current day of the week
    $currentDayOfWeek = $currentDate->dayOfWeek;

    // Calculate the difference in days
    $targetDayOfWeek = $daysOfWeek[$dayName];
    $daysDifference = $targetDayOfWeek - $currentDayOfWeek;

    // Get the date for that day in the current week
    return $currentDate->copy()->addDays($daysDifference)->startOfDay()->format('Y-m-d');
}


}
