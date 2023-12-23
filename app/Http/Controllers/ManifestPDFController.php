<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ManifestPDF;
use DataTables;
class ManifestPDFController extends Controller
{
/**
     * Display a listing of the resource.
     */
    public function index(Request $request, $id)
    {

        if ($request->ajax()) {
            $data = ManifestPDF::where('customer_id', $id)->get();
  
            if ($request->filled('from_date') && $request->filled('to_date')) {
                $data = $data->whereBetween('created_at', [$request->from_date, $request->to_date]);
            }
  
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('id', function($row){
                        return '000'.$row->order_id;
                    })
                    ->editColumn('generator', function($row){
                        $btn = '<a href='.url($row->generator).'>View</a>';
                            return $btn;
                    })
                    ->editColumn('transporter', function($row){
                        $btn = '<a href='.url($row->transporter).'>View</a>';
                            return $btn;
                    })
                    ->editColumn('processor', function($row){
                        $btn = '<a href='.url($row->processor).'>View</a>';
                            return $btn;
                    })
                    ->editColumn('disposal', function($row){
                        $btn = '<a href='.url($row->disposal).'>View</a>';
                            return $btn;
                    })
                    ->editColumn('original_generator', function($row){
                        $btn = '<a href='.url($row->original_generator).'>View</a>';
                            return $btn;
                    })
                    ->rawColumns(['generator','transporter','processor','disposal','original_generator'])
                    ->make(true);
        }

        $pdfManifest = ManifestPDF::where('customer_id', $id)->get();
        return view('books.list', compact('pdfManifest'));
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
    public function show(ManifestPDF $manifestPDF)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ManifestPDF $manifestPDF)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ManifestPDF $manifestPDF)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ManifestPDF $manifestPDF)
    {
        //
    }
}
