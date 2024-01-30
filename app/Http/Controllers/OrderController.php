<?php

namespace App\Http\Controllers;

use App\Models\Notes;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use DataTables;

class OrderController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Order::with(['customer', 'user', 'driver'])->get();

            if ($request->filled('from_date') && $request->filled('to_date')) {
                $fromDate = Carbon::parse($request->from_date);
                $toDate = Carbon::parse($request->to_date);
                $data = $data->whereBetween('created_at', [$fromDate, $toDate]);
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('id', function ($row) {
                    return $row->id;
                })
                ->editColumn('business_name', function ($row) {
                    if ($row->customer->business_name) {
                        return $row->customer->business_name;
                    }
                    return 'N/A';
                })
                ->editColumn('created_by', function ($row) {
                    if ($row->user->name) {
                        return $row->user->name;
                    }
                    return 'N/A';
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('M d Y');
                })
                ->editColumn('email', function ($row) {
                    return $row->customer->email;
                })
                ->editColumn('driver', function ($row) {
                    if ($row->driver)
                        return $row->driver->name;
                    return 'N/A';
                })
                // ->editColumn('update_driver', function ($row) {
                //     return '<a href="#" class="update_driver"> <i class="mdi mdi-account" data-order_id="'.$row->id.'"  title="Update Driver"></i></a>';
                // })
                // ->rawColumns(['update_driver'])
                ->make(true);
        }

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

        if ($request->create_order == 'createOrder') {
            Order::create([
                'customer_id' => $request['customer_id'],
                'user_id' => Auth::id(),
                'notes' => $request['notes'] ?? 'N/A',
                'load_type' => $request['load_type'],
                'driver_id' => $request['driver_id'] ?? null

            ]);
        }
        Notes::create([
            'customer_id' => $request['customer_id'],
            'user_id' => Auth::id(),
            'note' => $request['notes'] ?? 'N/A',
            'estimated_tires' => $request->estimated_tires ?? 'N/A',
            'spoke_with' => $request->spoke_with ?? 'N/A',
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

    public function getComparedOrders(Request $request)
    {
        if ($request->ajax()) {
            $data = Order::where('status', 'compared')->orWhereIn('load_type', ['tdf', 'trailer_swap'])->latest()->get();
            if ($request->filled('from_date') && $request->filled('to_date')) {
                $fromDate = Carbon::parse($request->from_date);
                $toDate = Carbon::parse($request->to_date);
                $data = $data->whereBetween('created_at', [$fromDate, $toDate]);
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('id', function ($row) {
                    return $row->id;
                })
                ->editColumn('business_name', function ($row) {
                    if ($row->customer->business_name) {
                        return $row->customer->business_name;
                    }
                    return 'N/A';
                })
                ->editColumn('created_by', function ($row) {
                    if ($row->user->name) {
                        return $row->user->name;
                    }
                    return 'N/A';
                })
                ->editColumn('load_type', function ($row) {
                    return $row->load_type;
                })

                ->editColumn('email', function ($row) {
                    return $row->customer->email;
                    return 'N/A';
                })

                ->editColumn('driver', function ($row) {
                    if ($row->driver)
                        return $row->driver->name;
                    return 'N/A';
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('M d Y');
                })

                ->editColumn('generate', function ($row) {
                    $route = route('generate.countsheet', $row->id);
                    $weightRoute = route('generate.weightsheet', $row->id);
                    // <a href="{{ route('generate.countsheet', $order->id) }}"> </a>
                    return '<a href=' . $route . '> Count Sheet</a>' . ($row->load_type == 'box_truck_route' ? ' / <a href=' . $weightRoute . '>Weight Sheet</a>' : '');
                })
                ->rawColumns(['generate'])
                ->make(true);
        }
        $orders = Order::where('status', 'compared')->orWhereIn('load_type', ['tdf', 'trailer_swap'])->latest()->get();
        return view('orders.compared.index', compact('orders'));
    }

    public function getTodaysManifestForDriver()
    {
        $orderStatus = ['compared', 'fulfilled'];
        $orders = Order::whereDate('created_at', now()->toDateString())
            ->where('driver_id', Auth::id())->whereIn('status', $orderStatus)->get();

        return view('orders.driver.manifest', compact('orders'));
    }

    public function getUnfilledManifest(Request $request)
    {

        if ($request->ajax()) {
            $data = Order::where('is_filled_by_manager', false)->get();
            if ($request->filled('from_date') && $request->filled('to_date')) {
                $fromDate = Carbon::parse($request->from_date);
                $toDate = Carbon::parse($request->to_date);
                $data = $data->whereBetween('created_at', [$fromDate, $toDate]);
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('id', function ($row) {
                    return $row->id;
                })
                ->editColumn('business_name', function ($row) {
                    if ($row->customer->business_name) {
                        return $row->customer->business_name;
                    }
                    return 'N/A';
                })
                ->editColumn('created_by', function ($row) {
                    if ($row->user->name) {
                        return $row->user->name;
                    }
                    return 'N/A';
                })

                ->editColumn('email', function ($row) {
                    return $row->customer->email;
                    return 'N/A';
                })

                ->editColumn('driver', function ($row) {
                    if ($row->driver)
                        return $row->driver->name;
                    return 'N/A';
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('M d Y');
                })

                ->editColumn('action', function ($row) {
                    $route = route('unfill.manifest.order', $row->id);
                    return '<a href=' . $route . '> <i class="mdi mdi-note " 
                    ></i></a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $orders = Order::where('is_filled_by_manager', false)->get();
        return view('orders.unfill.index', compact('orders'));
    }

    public function getUnfilledManifestOrder($id)
    {
        $order = Order::find($id);
        return view('orders.unfill.create', compact('order'));
    }

    public function apiCreateOrder(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'customer_id' => ['required'],
                    'notes' => ['required'],
                    'load_type' => ['required'],
                    'driver_id' => ['required']

                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $order = Order::create([
                'customer_id' => $request['customer_id'],
                'user_id' => Auth::id(),
                'notes' => $request['notes'] ?? 'N/A',
                'load_type' => $request['load_type'],
                'driver_id' => $request['driver_id'] ?? null

            ]);

            return response()->json([
                'status' => true,
                'message' => 'Order Created Successfully',
                'user' => $order,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function apiGetCompareOrders()
    {
        try {
            $orders = Order::where('status', 'compared')->orWhereIn('load_type', ['tdf', 'trailer_swap'])->with('customer')->latest()->get();
            return response()->json([
                'status' => true,
                'message' => 'Orders',
                'orders' => $orders,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function apiGetFulFillOrders()
    {
        try {
            $fullFilledOrderStatus = ['error-compared', 'fulfilled'];
            $orders = Order::whereIn('status', $fullFilledOrderStatus)->where('load_type', '<>', 'tdf')->with(['customer', 'user', 'driver'])->get();
            return response()->json([
                'status' => true,
                'message' => 'Orders',
                'orders' => $orders,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
