<?php

namespace App\Http\Controllers;

use App\Events\OrderCreated;
use App\Models\Notes;
use App\Models\Order;
use App\Models\Truck;
use App\Models\TruckDriver;
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
        $trucks = Truck::where('is_active', true)->get();

        if ($request->ajax()) {
            $data = Order::with(['customer', 'user', 'driver'])->get();
            if ($request->filled('from_date') && $request->filled('to_date')) {
                $fromDate = Carbon::parse($request->from_date);
                $toDate = Carbon::parse($request->to_date)->endOfDay();
                $data = $data->whereBetween('delivery_date', [$fromDate->toDateString(), $toDate->toDateString()]);
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
                    return $row->delivery_date;
                })
                ->editColumn('email', function ($row) {
                    return $row->customer->email;
                })
                ->editColumn('truck_no', function ($row) {
                        return $row->truck_no;
                })
                ->editColumn('update_truck', function ($row) {
                    $button = '
                    <button type="button" data-order_id="' . $row->id . '" class="btn btn-warning btn-sm" onclick="updateTruck(\'' . $row->id . '\')">Update Truck
                    </button>
                ';
                    $showBtn = '';

                    if ($row->status == 'created') {
                        $orderShowRoute = route('order.show', $row->id);
                        $showBtn = '/<a href="' . $orderShowRoute . '" > <i class="fa fa-edit"  title="update order"></i></a>';
                    }
                    $orderDeleteRoute = route('order.delete', $row->id);

                    $deleteBtn = ' /<a href="' . $orderDeleteRoute . '" > <i class="fa fa-times text-primary"  title="delete order"></i></a>';
                    return $button . $showBtn . $deleteBtn;
                })
                ->rawColumns(['update_truck'])
                ->make(true);
        }

        $drivers = User::where('type', 2)->get();
        $orders = Order::with(['customer', 'user', 'driver'])->get();
        return view('orders.index', compact('orders', 'drivers', 'trucks'));
    }

    public function ordersByTruck(Request $request)
    {
        if ($request->ajax()) {
            $data = Order::with(['customer', 'user', 'truck'])->get();

            if ($request->filled('from_date') && $request->filled('to_date')) {
                $fromDate = Carbon::parse($request->from_date);
                $toDate = Carbon::parse($request->to_date)->endOfDay();
                $data = $data->whereBetween('delivery_date', [$fromDate->toDateString(), $toDate->toDateString()]);
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
                ->editColumn('delivery_date', function ($row) {
                    if ($row->delivery_date) {
                        if ($row->delivery_date instanceof \DateTime) {
                            return $row->delivery_date->format('M d Y');
                        } else {
                            // If it's a string, you might need to parse it into a DateTime object
                            $deliveryDate = \DateTime::createFromFormat('Y-m-d', $row->delivery_date);
                            if ($deliveryDate !== false) {
                                return $deliveryDate->format('M d Y');
                            } else {
                                return 'Invalid date';
                            }
                        }
                    }
                    return 'N/A';
                })
                ->editColumn('email', function ($row) {
                    return $row->customer->email;
                })
                ->editColumn('truck', function ($row) {
                    if ($row->truck)
                        return $row->truck->name;
                    return 'N/A';
                })->editColumn('status', function ($row) {
                    if ($row->status)
                        return $row->status;
                    return 'N/A';
                })
                ->make(true);
        }

        $drivers = User::where('type', 2)->get();
        $orders = Order::with(['customer', 'user', 'driver'])->get();
        return view('orders.driver.driver_filter', compact('orders', 'drivers'));
    }

    public function lateOrders(Request $request)
    {
        if ($request->ajax()) {
            $currentDate = Carbon::now();
            $data = Order::where('status', 'created')
                ->whereDate('end_date', '<=', $currentDate)
                ->with(['customer', 'user', 'driver'])
                ->get();
            if ($request->filled('from_date') && $request->filled('to_date')) {
                $fromDate = Carbon::parse($request->from_date);
                $toDate = Carbon::parse($request->to_date)->endOfDay();
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
                ->editColumn('end_date', function ($row) {
                    if (!empty($row->end_date)) {
                        return Carbon::parse($row->end_date)->format('M d Y');
                    } elseif (!empty($row->created_at)) {
                        return Carbon::parse($row->created_at)->format('M d Y');
                    }
                    return 'N/A';
                })
                ->editColumn('email', function ($row) {
                    return $row->customer->email;
                })
                ->editColumn('driver', function ($row) {
                    if ($row->driver)
                        return $row->driver->name;
                    return 'N/A';
                })->editColumn('status', function ($row) {
                    if ($row->status)
                        return $row->status;
                    return 'N/A';
                })
                ->make(true);
        }

        $drivers = User::where('type', 2)->get();
        $orders = Order::with(['customer', 'user', 'driver'])->get();
        return view('orders.late', compact('orders', 'drivers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $drivers = User::where('type', 2)->get();
        $customerId = $request->query('customerId');
        $trucks = Truck::where('is_active', true)->get();

        return view('orders.create', compact('drivers', 'customerId', 'trucks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $truckID = $request['truck_id'] ?? null;

        // Check if truck_id is provided in the request
        if (!$truckID) {
            return; // Exit the function if truck_id is not provided
        }

        // Calculate number of orders needed based on estimated_tires
        $estimatedTires = $request->estimated_tires;
        $numOrders = ceil($estimatedTires / 400);

        // Loop to create orders
        if ($request->create_order == 'createOrder') {
            for ($i = 0; $i < $numOrders; $i++) {
                // Determine the amount of tires for this order
                $orderTires = min(400, $estimatedTires); // Maximum 400 tires per order

                // Create the order
                $this->createOrder($request, $truckID, $orderTires);

                // Decrease remaining estimated_tires
                $estimatedTires -= $orderTires;
            }
        }

        Notes::create([
            'customer_id' => $request['customer_id'],
            'user_id' => Auth::id(),
            'note' => $request['notes'] ?? 'N/A',
            'estimated_tires' => $request->estimated_tires ?? 'N/A',
            'spoke_with' => $request->spoke_with ?? 'N/A',
            'title' => 'Order Note'
        ]);

        if ($request->create_order === 'createOrder') {
            return redirect('/orders')->with('success', 'Order(s) Created Successfully');
        } else {
            return redirect('/orders')->with('success', 'Note Created Successfully');
        }
    }

    private function createOrder($request, $truckId, $estimatedTires)
    {

        return Order::create([
            'customer_id' => $request['customer_id'],
            'user_id' => Auth::id(),
            'notes' => $request['notes'] ?? 'N/A',
            'load_type' => $request['load_type'],
            'truck_id' => $truckId,
            'delivery_date' => $request['date'],
            'end_date' => $request['end_date'],
            'is_recurring_order' => $request['is_recurring_order'] == 'on',
            'estimated_tires' => $estimatedTires,
            'frequency'=>$request->frequency
        ]);
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
        $truckDriver = TruckDriver::where('user_id', Auth::id())->latest()->first();
        if ($truckDriver) {
            $orders = Order::where([['truck_id', $truckDriver->truck_id], ['status', 'created']])->with(['customer', 'user', 'manifest'])->latest()->get();
            return view('orders.driver.index', compact('orders'));
        }
        return back()->with('error', 'truck is not assigned to you');
    }

    public function updateDriver(Request $request)
    {
        $orderID = $request->order_id;
        $truckId = $request->truck_id;
        $order = Order::find($orderID);
        // if ($order && $order->driver_id == $driverID) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Order is already assigned to this driver'
        //     ]);
        // }

        $truckDriver = TruckDriver::where('truck_id', $truckId)->latest()->first();


        if ($order) {
            $order->truck_id = $truckId;
            $order->update();
            return response()->json([
                'success' => true,
                'message' => 'Order is successfully assigned to truck'
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
                $toDate = Carbon::parse($request->to_date)->endOfDay();
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
        $truckDriver = TruckDriver::where('user_id', Auth::id())->latest()->first();

        $orders = Order::whereDate('created_at', now()->toDateString())
            ->where('truck_id', $truckDriver->truck_id)->whereIn('status', $orderStatus)->get();

        return view('orders.driver.manifest', compact('orders'));
    }

    public function getUnfilledManifest(Request $request)
    {

        if ($request->ajax()) {
            $data = Order::where('is_filled_by_manager', false)->with(['customer', 'driver', 'user'])->get();
            if ($request->filled('from_date') && $request->filled('to_date')) {
                $fromDate = Carbon::parse($request->from_date);
                $toDate = Carbon::parse($request->to_date)->endOfDay();
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
        $order = Order::whereId($id)->with('customer')->first();
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

    public function getOrderById($id)
    {
        $order = Order::whereId($id)->with(['customer', 'driver'])->first();
        $drivers = User::where('type', 2)->get();
        return view('orders.show', compact('order', 'drivers'));
    }

    public function updateOrder(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->load_type = $request['load_type'];
        $order->driver_id = $request['driver_id'];
        $order->delivery_date = $request['date'];
        $order->update();

        Notes::create([
            'customer_id' => $request['customer_id'],
            'user_id' => Auth::id(),
            'note' => $request['notes'] ?? 'N/A',
            'estimated_tires' => $request->estimated_tires ?? 'N/A',
            'spoke_with' => $request->spoke_with ?? 'N/A',
            'title' => 'Updated Order Note'
        ]);

        return redirect('/orders')->with('success', 'Order Updated Successfully');
    }

    public function deleteOrder($id)
    {
        Order::find($id)->delete();
        return back()->with('success', 'Order is deleted successfully');
    }

    public function completeOrder(Request $request){
        $order = Order::findOrFail($request->order_id);
        if($order){
            $order->notes = $request->complete_order_notes;
            $order->status = 'completed';
            $order->save();

            Notes::create([
                'customer_id' => $order->customer_id,
                'user_id' => Auth::id(),
                'note' => $request['complete_order_notes'] ?? 'N/A',
                'estimated_tires' => $request->estimated_tires ?? 'N/A',
                'spoke_with' => $request->spoke_with ?? 'N/A',
                'title' => 'Order Note'
            ]);


        };
        return back()->with('success', 'Order completed');
    }
}
