<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $drivers = User::where('type', 2)->get();
        return view('driver.index', compact('drivers'));
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
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $request->merge([
            'type' => 2
        ]);

        User::create($request->all());
        return redirect('/register-driver')->with('success', 'Driver Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Driver $driver)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Driver $driver)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Driver $driver)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Driver $driver)
    {
        //
    }

    public function deleteDriver($id)
    {
        User::where('id', $id)->delete();
        return back()->with('success', 'Driver Deleted Successfully');
    }

    public function getOrders($id)
    {
        $orders = Order::where('driver_id', $id)->orderBy('created_at', 'DESC')->get();
        $driver = User::find($id);
        return view('driver.orders', compact('orders', 'driver'));
    }

    public function showDriverDetails($id)
    {
        $user = User::find($id);
        return view('driver.show', compact('user'));
    }

    public function updateDriver(Request $request)
    {
        $user = User::find($request->user_id);
        if ($user) {
            $user->name = $request->name;
            $user->driver_license = $request->driver_license;
            if ($request->password)
                $user->password = Hash::make($request->password);

            $user->update();

            return back()->with('success', 'Driver is updated successfully');
        }
    }

    public function apiGetDriverOrders($id)
    {
        try {
            $orders = Order::where('driver_id', $id)->where('status', 'created')->with('customer')->get();
            return response()->json([
                'status' => true,
                'message' => 'Driver Orders',
                'data' => $orders,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function apiGetLoggedInDriverOrders()
    {

        try {
            $orders = Order::where([['driver_id', Auth::id()], ['status', 'created']])->with(['customer', 'user', 'manifest'])->latest()->get();
            return response()->json([
                'status' => true,
                'message' => 'Driver Orders',
                'data' => $orders,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
