<?php

namespace App\Http\Controllers;

use App\Models\CustomerPricing;
use App\Models\CustomPricing;
use Illuminate\Http\Request;

class CustomPricingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customPricing = CustomPricing::first();
        return view('custom_pricing.index', compact('customPricing'));
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
        // Since there will only be one record, we'll find the first (or create if it doesn't exist)
        $customerPricing = CustomPricing::first();
    
        if ($customerPricing) {
            // If a record exists, update it
            $customerPricing->update($request->all());
        } else {
            // If no record exists, create a new one
            CustomPricing::create($request->all());
        }
    
        return back()->with('success', 'Price updated successfully');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(CustomPricing $customPricing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomPricing $customPricing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CustomPricing $customPricing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomPricing $customPricing)
    {
        //
    }
}
