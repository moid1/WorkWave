<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Truck;
use App\Models\TruckDriver;
use App\Models\User;
use App\Models\Driver;
use Illuminate\Http\Request;

class TruckController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trucks = Truck::with('truckDriver')->get();
        $drivers = User::where('type', 2)->get();
        return view('truck.index', compact('trucks', 'drivers'));
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
        $isTruckExists = Truck::where('name', $request->name)->exists();
        if ($isTruckExists) {
            return back()->with('error', 'Truck Name Already Exists');
        }
        Truck::create($request->all());
        return back()->with('success', 'Truck Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Truck $truck)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Truck $truck)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Truck $truck)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Truck $truck)
    {
        //
    }

    public function changeTruckStatus($id)
    {
        $truck = Truck::find($id);
        if ($truck) {
            $truck->is_active = !$truck->is_active;
            $truck->update();
            return back()->with('success', 'Truck Status has been changed successfully');
        }
    }

    public function assignTruckToDriver(Request $request)
    {
        $truckDriver = TruckDriver::where('id', $request->truck_id)->first();

        if ($truckDriver) {
            Order::where('driver_id', $truckDriver->user_id)
                 ->update(['driver_id' => $request->user_id]);
        }
        
        TruckDriver::updateOrCreate(['truck_id' => $request->truck_id], $request->all());
        
        return response()->json([
            'success' => true,
            'message' => 'Truck Assigned to the Driver'
        ]);
    }

    public function updateTruck($id)
    {
        $truck = Truck::find($id);
        if ($truck) {
            return view('truck.update', compact('truck'));
        }
        return back()->with('error', 'Sorry, Truck is not available');
    }

    public function updateTruckStore(Request $request)
    {
        $truck = Truck::find($request->truck_id);
        if ($truck) {
            $truck->name = $request->name;
            $truck->update();
            return redirect('/truck');
        }
        return back()->with('error', 'Sorry, Truck is not available');
    }

    public function liveTrucks()
    {
        $latestLocations = Driver::join(\DB::raw('(SELECT users_id, MAX(created_at) AS latest_date FROM drivers GROUP BY users_id) latest'), function ($join) {
            $join->on('drivers.users_id', '=', 'latest.users_id')
                 ->on('drivers.created_at', '=', 'latest.latest_date');
        })
        ->join('truck_drivers', 'truck_drivers.user_id', '=', 'drivers.users_id')
        ->join('trucks', 'trucks.id', '=', 'truck_drivers.truck_id')
        ->select('drivers.*', 'trucks.*')
        ->distinct()
        ->get();
        $trailers = Order::where('load_type', 'trailer_swap')->with(['customer', 'trailerSwapOrder'])->get();
        
        // dd($latestLocations);
       return view('truck.live', compact('latestLocations', 'trailers'));
    }
}
