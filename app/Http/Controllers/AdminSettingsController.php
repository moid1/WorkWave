<?php

namespace App\Http\Controllers;

use App\Models\AdminSettings;
use Illuminate\Http\Request;

class AdminSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $adminSettings = AdminSettings::first();
        return view('admin.index', compact('adminSettings'));
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
        $adminSettings = AdminSettings::first();
        if ($adminSettings) {
            $adminSettings->update($request->all());
        } else {
            AdminSettings::create($request->all());
        }
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(AdminSettings $adminSettings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AdminSettings $adminSettings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AdminSettings $adminSettings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AdminSettings $adminSettings)
    {
        //
    }
}
