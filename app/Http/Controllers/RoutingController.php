<?php

namespace App\Http\Controllers;

use App\Events\RouteCreated;
use App\Models\Order;
use App\Models\Routing;
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
            'route_name' => ['required'],
            'driver_id' => ['required']
        ]);

        try {
            // Begin a database transaction
            DB::beginTransaction();

            // Create a new routing entry
            $routing = Routing::create($request->all());

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
        return view('routing.create', compact('drivers'));
    }

    public function getDriverOrderRouting(Request $request)
    {
        $data = Order::where('driver_id', $request->driver_id)
            ->where('is_routed', false)
            ->with(['customer', 'user', 'driver'])
            ->get();

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $fromDate = Carbon::parse($request->from_date);
            $toDate = Carbon::parse($request->to_date)->endOfDay();
            $data = $data->whereBetween('delivery_date', [$fromDate->toDateString(), $toDate->toDateString()]);
        }

        // Convert each item in the collection to a plain array
$dataArray = $data->map(function ($item) {
    return $item->toArray();
});


        return response()->json($dataArray);
    }
}
