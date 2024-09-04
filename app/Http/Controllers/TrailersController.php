<?php

namespace App\Http\Controllers;

use App\Models\Trailers;
use Illuminate\Http\Request;

class TrailersController extends Controller
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
        Trailers::create($request->all());
        return back()->with('success', 'trailer added');
    }

    /**
     * Display the specified resource.
     */
    public function show(Trailers $trailers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Trailers $trailers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Trailers $trailers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trailers $trailers)
    {
        //
    }
}
