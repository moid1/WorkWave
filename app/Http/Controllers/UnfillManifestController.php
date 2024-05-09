<?php

namespace App\Http\Controllers;

use App\Models\CustomerPricing;
use App\Models\FullFillOrder;
use App\Models\ManifestPDF;
use App\Models\Order;
use App\Models\TrailerSwapOrder;
use App\Models\UnfillManifest;
use Illuminate\Http\Request;

class UnfillManifestController extends Controller
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
        $folderPath = 'signatures/';

        $image_parts = explode(";base64,", $request->signed);

        $image_type_aux = explode("image/", $image_parts[0]);

        if (!$image_type_aux[0] != '') {
            return back()->with('error', 'Signature Required');
        }

        $image_type = $image_type_aux[1];


        $image_base64 = base64_decode($image_parts[1]);

        $file = $folderPath . uniqid() . '.' . $image_type;
        file_put_contents($file, $image_base64);

        $request->merge([
            'signature' => $file
        ]);

        $unfillManifest = UnfillManifest::updateOrCreate(['order_id'=>$request->order_id], $request->except('signed'));

        $order = Order::find($request->order_id);
        $order->is_filled_by_manager = true;
        $order->update();
        if ($order) {
            if ($order->load_type == 'box_truck_route') {
                return $this->fillBoxTruck($unfillManifest);
            }else if($order->load_type == 'trailer_swap'){
                return $this->fillTrailerSwap($unfillManifest);
            }
        }




        return back()->with('success', 'Information has been saved successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(UnfillManifest $unfillManifest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UnfillManifest $unfillManifest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UnfillManifest $unfillManifest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UnfillManifest $unfillManifest)
    {
        //
    }

    public function fillBoxTruck($unfulfillData)
    {
        $pdfTypes = ['Generator', 'Transporter', 'Processor', 'Disposal', 'Original Generator'];
        // $pdfTypes = ['Generator'];

        $order = Order::where('id', $unfulfillData->order_id)->with(['customer', 'user'])->first();
        $customerPricing = CustomerPricing::where('customer_id', $order->customer->id)->first();
        $fullFillOrder =  FullFillOrder::where('order_id', $unfulfillData->order_id)->first();

        $fullFillOrder['order'] = $order;
        $fullFillOrder['unfill'] = $unfulfillData;
        $fullFillOrder['customerPricing'] = $customerPricing;
        $existingManifest = ManifestPDF::where('order_id', $order->id)->first();
        if(!$existingManifest){
            dd('FulFil the manifest first');
        }

        for ($i = 0; $i < count($pdfTypes); $i++) {
            $fullFillOrder['pdfType'] = $pdfTypes[$i];
            $pdf = \App::make('dompdf.wrapper');

            $customPaper = array(0, 0, 900, 1500);
            $pdf->setPaper($customPaper);
            $pdf->loadView('orders.unfill.manifest.index', ['data' => $fullFillOrder]);

            $output = $pdf->output();
            $test = $pdf;
            // return $pdf->stream();
            $pdfPath = public_path() . '/manifest/pdfs/' . time() . '.pdf';
            $abPDFPath  = 'manifest/pdfs/' . time() . '.pdf';
            file_put_contents($pdfPath, $output);
            switch ($pdfTypes[$i]) {
                case 'Generator':
                    $existingManifest->generator = $abPDFPath;
                    break;
                case 'Transporter':
                    $existingManifest->transporter = $abPDFPath;
                    break;
                case 'Processor':
                    $existingManifest->processor = $abPDFPath;
                    break;
                case 'Disposal':
                    $existingManifest->disposal = $abPDFPath;
                    break;
                case 'Original Generator':
                    $existingManifest->original_generator = $abPDFPath;
                    break;

                default:
                    break;
            }
            //  return view('manifest.index');
        }
        $existingManifest->update();
        return $test->stream();
    }

    public function fillTrailerSwap($unfulfillData){
        $pdfTypes = ['Generator', 'Transporter', 'Processor', 'Disposal', 'Original Generator'];
        // $pdfTypes = ['Generator'];
        $fullFillOrder = TrailerSwapOrder::where('order_id', $unfulfillData->order_id)->first();


        $order = Order::where('id', $unfulfillData->order_id)->with(['customer', 'user'])->first();
        $customerPricing = CustomerPricing::where('customer_id', $order->customer_id)->first();
        $fullFillOrder['unfill'] = $unfulfillData;
        $fullFillOrder['order'] = $order;
        $fullFillOrder['customerPricing'] = $customerPricing;

        $existingManifest = ManifestPDF::where('order_id', $order->id)->first();
        if(!$existingManifest){
            dd('FulFil the manifest first');
        }

        $test = null;
        for ($i = 0; $i < count($pdfTypes); $i++) {
            $fullFillOrder['pdfType'] = $pdfTypes[$i];
            $pdf = \App::make('dompdf.wrapper');

            $customPaper = array(0, 0, 900, 1300);
            $pdf->setPaper($customPaper);
            $pdf->loadView('orders.unfill.manifest.index', ['data' => $fullFillOrder]);

            $output = $pdf->output();
            $test = $pdf;
            // return $pdf->stream();
            $pdfPath = public_path() . '/manifest/pdfs/' . time() . '.pdf';
            $abPDFPath  = 'manifest/pdfs/' . time() . '.pdf';
            file_put_contents($pdfPath, $output);
            switch ($pdfTypes[$i]) {
                case 'Generator':
                    $existingManifest->generator = $abPDFPath;
                    break;
                case 'Transporter':
                    $existingManifest->transporter = $abPDFPath;
                    break;
                case 'Processor':
                    $existingManifest->processor = $abPDFPath;
                    break;
                case 'Disposal':
                    $existingManifest->disposal = $abPDFPath;
                    break;
                case 'Original Generator':
                    $existingManifest->original_generator = $abPDFPath;
                    break;

                default:
                    break;
            }
            //  return view('manifest.index');
        }
        $existingManifest->update();
        return $test->stream();
    }
}
