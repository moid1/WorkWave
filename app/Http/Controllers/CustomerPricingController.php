<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerPricing;
use Illuminate\Http\Request;

class CustomerPricingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();
        return view('customers.pricing.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $customerPricing = CustomerPricing::whereCustomerId($id)->with('customer')->latest()->first();
        $customerId = $id;
        return view('customers.pricing.create', compact('customerPricing', 'customerId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $customerPricing = CustomerPricing::updateOrCreate(['customer_id' => $request->customer_id], $request->except(['customer_id']));
        return back()->with('success', 'Price updated successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(CustomerPricing $customerPricing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomerPricing $customerPricing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CustomerPricing $customerPricing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomerPricing $customerPricing)
    {
        //
    }
}
