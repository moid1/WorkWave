<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use App\Models\User;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Manager $manager)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Manager $manager)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Manager $manager)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Manager $manager)
    {
        //
    }

    public function apiGetAllManagers()
    {
        try {
            $allManagers = Manager::with('user')->get();

            return response()->json([
                'status' => true,
                'message' => 'All Managers List',
                'data' => $allManagers,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function apiGetAllDrivers()
    {
        try {
            $allManagers = User::where('type', 2)->get();
            return response()->json([
                'status' => true,
                'message' => 'All Drivers List',
                'data' => $allManagers,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
