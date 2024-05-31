<?php

namespace App\Http\Controllers;

use App\Models\CallingTable;
use App\Models\Customer;
use App\Models\Truck;
use Illuminate\Http\Request;

class CallingTableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $week = $request->week ?? '1'; // Default to week 1 if not provided from frontend

        $callingTable = CallingTable::whereNotNull('day')->where('week', $week)
            ->get()
            ->groupBy(['truck_id', 'day'])
            ->toArray();
    
        return view('callingtable.index', compact('callingTable', 'week'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all(['id', 'business_name']);
        $trucks = Truck::all(['id', 'name']);
        return view('callingtable.create', compact('customers', 'trucks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $customers = implode(',', $request->customers);

        // Check if the record already exists
        $existingRecord = CallingTable::where('truck_id', $request->truck)
            ->where('day', $request->day)
            ->where('week', $request->week)
            ->first();
        
        if ($existingRecord) {
            // Update the existing record
            $existingRecord->update([
                'customer_ids' => $customers,
            ]);
        
            return back()->with('success', 'Calling table updated successfully.');
        } else {
            // Create a new record
            CallingTable::create([
                'truck_id' => $request->truck,
                'customer_ids' => $customers,
                'day' => $request->day,
                'week' => $request->week
            ]);
        
            return back()->with('success', 'Calling table created successfully.');
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(CallingTable $callingTable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CallingTable $callingTable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CallingTable $callingTable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CallingTable $callingTable)
    {
        //
    }
}
