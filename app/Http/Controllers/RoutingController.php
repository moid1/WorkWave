<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Routing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
