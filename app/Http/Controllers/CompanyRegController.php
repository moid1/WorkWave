<?php

namespace App\Http\Controllers;

use App\Models\CompanyReg;
use Illuminate\Http\Request;

class CompanyRegController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companyReg = CompanyReg::all();
        return view('company.index', compact('companyReg'));
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
        $this->validate($request,[
            'reg_no' => ['required', 'string', 'max:255']
         ]);

         $companyRegistration = CompanyReg::create($request->all());
         return back()->with('success', 'Registration no has been added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(CompanyReg $companyReg)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CompanyReg $companyReg)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CompanyReg $companyReg)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CompanyReg $companyReg)
    {
        //
    }

    public function delete($id){
        CompanyReg::find($id)->delete();
        return back()->with('success', 'Registration no has been deleted successfully');
    }
}
