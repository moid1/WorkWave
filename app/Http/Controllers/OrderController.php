<?php

namespace App\Http\Controllers;

use App\Models\Notes;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{

    protected $WORKWAVE_URL = 'https://wwrm.workwave.com/api/v1/territories/9c7ab89c-81d3-4d0a-9cd8-61390a286ad8/orders';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $drivers = User::where('type', 2)->get();
        $orders = Order::with(['customer', 'user', 'driver'])->get();
        return view('orders.index', compact('orders', 'drivers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $drivers = User::where('type', 2)->get();
        return view('orders.create', compact('drivers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        Order::create([
            'customer_id' => $request['customer_id'],
            'user_id' => Auth::id(),
            'notes' => $request['notes'] ?? 'N/A',
            'load_type' => $request['load_type'],
            'driver_id' => $request['driver_id'] ?? null

        ]);

        Notes::create([
            'customer_id' => $request['customer_id'],
            'user_id' => Auth::id(),
            'note' => $request['notes'] ?? 'N/A',
            'title' => 'Order Note'
        ]);
        return redirect('/orders')->with('success', 'Order Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    public function callWorkWave($data)
    {

        $response = Http::withHeaders([
            'X-WorkWave-Key' => '476563b3-8bc4-4493-81e6-4098be89dbbc',
        ])->post($this->WORKWAVE_URL, $data, $data);

        return ($response->json());
    }

    public function driverOrders()
    {
        $orders = Order::where([['driver_id', Auth::id()], ['status', 'created']])->with(['customer', 'user', 'manifest'])->latest()->get();
        return view('orders.driver.index', compact('orders'));
    }

    public function updateDriver(Request $request)
    {
        $orderID = $request->order_id;
        $driverID = $request->driver_id;
        $order = Order::find($orderID);
        if ($order &&    $order->driver_id == $driverID) {
            return response()->json([
                'success' => false,
                'message' => 'Order is already assigned to this driver'
            ]);
        }
        if ($order) {
            $order->driver_id = $driverID;
            $order->update();
            return response()->json([
                'success' => true,
                'message' => 'Order is successfully assigned to driver'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Sorry, Order not found'
        ]);
    }

    public function apiGetOrders()
    {
        try {
            $drivers = User::where('type', 2)->get();
            $orders = Order::with(['customer', 'user', 'driver'])->get();

            return response()->json([
                'status' => true,
                'message' => 'Driver Registered Successfully',
                'data' => [
                    'drivers' => $drivers,
                    'orders' => $orders
                ]
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function apiUpdateDriver(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'order_id' => ['required'],
                    'driver_id' => ['required'],
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }


            $orderID = $request->order_id;
            $driverID = $request->driver_id;
            $order = Order::find($orderID);
            if ($order && $order->driver_id == $driverID) {
                return response()->json([
                    'status' => true,
                    'message' => 'This driver is already assigned to this order',
                    'data' => null
                ], 200);
              
            }
            if ($order) {
                $order->driver_id = $driverID;
                $order->update();
                return response()->json([
                    'success' => true,
                    'message' => 'Order is assigned to this driver successfully',
                    'data' => $order
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'Sorry, Order not found'
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getComparedOrders(){
        $orders = Order::where('status', 'compared')->orWhereIn('load_type',['tdf', 'trailer_swap'])->latest()->get();
        return view('orders.compared.index', compact('orders'));
    }
}
