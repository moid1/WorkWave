<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ManifestPDF;
use DataTables;
use Carbon\Carbon;
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
                $fromDate = Carbon::parse($request->from_date)->format('YYYY-MM-DD');
                $toDate = Carbon::parse($request->to_date)->endOfDay();
                $data = $data->whereBetween('created_at', [$fromDate, $toDate]);
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('id', function ($row) {
                    return '000' . $row->order_id;
                })
                ->editColumn('generator', function ($row) {
                    if ($row->generator) {
                        $btn = '<a href=' . url($row->generator) . '>View</a>';
                        return $btn;
                    }
                    return 'N/A';
                })
                ->editColumn('transporter', function ($row) {
                    if ($row->transporter) {
                        $btn = '<a href=' . url($row->transporter) . '>View</a>';
                        return $btn;
                    }
                    return 'N/A';
                })
                ->editColumn('processor', function ($row) {
                    if ($row->processor) {
                        $btn = '<a href=' . url($row->processor) . '>View</a>';
                        return $btn;
                    }
                    return 'N/A';
                })
                ->editColumn('disposal', function ($row) {
                    if ($row->disposal) {
                        $btn = '<a href=' . url($row->disposal) . '>View</a>';
                        return $btn;
                    }
                    return 'N/A';
                })
                ->editColumn('original_generator', function ($row) {
                    if ($row->original_generator) {
                        $btn = '<a href=' . url($row->original_generator) . '>View</a>';
                        return $btn;
                    }
                    return 'N/A';
                })
                ->editColumn('count_sheet', function ($row) {
                    if ($row->count_sheet) {
                        $btn = '<a href=' . url($row->count_sheet ?? '') . '>View</a>';
                        return $btn;
                    }
                    return 'N/A';
                })
                ->rawColumns(['generator', 'transporter', 'processor', 'disposal', 'original_generator', 'count_sheet'])
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
