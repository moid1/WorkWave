<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Notes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notes = Notes::with(['customer', 'user'])->get();
        return view('notes.index', compact('notes'));
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


        Notes::create([
            'customer_id' => $request['customer_id'],
            'user_id' => Auth::id(),
            'note' => $request['note'] ?? 'N/A',
            'title' => $request['notes_title'] ?? 'N/A',

        ]);

        return redirect()->back()->with('success', 'Note created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Notes $notes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $note = Notes::find($id);
        return response()->json($note);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $note = Notes::find($id);
        $note->note = $request->note;
        $note->estimated_tires = $request->estimated_tires;
        $note->spoke_with = $request->spoke_with;
        $note->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $note = Notes::find($id);
        $note->delete();

        return redirect()->back();
    }

    public function getUserNotes($id)
    {
        $notes = Notes::where('customer_id', $id)->orderBy('created_at', 'desc')->get();
        $customer = Customer::find($id);
        return view('notes.user-notes', compact('notes', 'customer'));
    }

    public function apiGetAllCustomersNotes(Request $request)
    {
        try {
            if (!$request->customer_id) {
                return response()->json([
                    'status' => true,
                    'message' => 'Customer Id is required',
                ], 400);
            }
            $notes = Notes::where([['customer_id', $request->customer_id]])->orderBy('created_at', 'DESC')->get();
            return response()->json([
                'status' => true,
                'message' => 'Customer Notes',
                'data' => $notes,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


    public function getLastNote(Request $request)
    {
        try {
            $note = Notes::where('customer_id', $request->id)->latest()->first();

            return response()->json([
                'status' => true,
                'message' => 'Customer Note',
                'data' => $note,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
