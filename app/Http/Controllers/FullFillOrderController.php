<?php

namespace App\Http\Controllers;

use App\Models\FullFillOrder;
use App\Models\ManifestPDF;
use App\Models\Order;
use Illuminate\Http\Request;

class FullFillOrderController extends Controller
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
    public function create($id)
    {
        $order = Order::where('id', $id)->with(['customer', 'user'])->first();

        return view('orders.fulfill.create', compact('order'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $pdfTypes = ['Generator','Transporter', 'Processor', 'Disposal', 'Original Generator'];
        $this->validate($request,[
            'processor_reg_no' => ['required'],
            'storage_reg_no' => ['required'],
         ]);

         $folderPath ='signatures/';

         $image_parts = explode(";base64,", $request->signed);
 
         $image_type_aux = explode("image/", $image_parts[0]);
         if(!$image_type_aux[0] != ''){
             return back()->with('error', 'Signature Required');
         }
         $image_type = $image_type_aux[1];
 
         $image_base64 = base64_decode($image_parts[1]);
 
         $file = $folderPath . uniqid() . '.' . $image_type;
         file_put_contents($file, $image_base64);
 

        $fullFillOrder =  FullFillOrder::create([
            'no_of_passenger' => $request->passenger_tire ?? 'N/A',
            'no_of_agri_tyre' => $request->agri_tire,
            'no_of_truck_tyre' => $request->truck_tire,
            'no_of_other'=> $request->other_tire,
            'order_id' => $request->order_id,
            'processor_reg_no' => $request->processor_reg_no,
            'storage_reg_no' => $request->storage_reg_no,
            'customer_signature' => $file

         ]);
         $order = Order::where('id', $request->order_id)->with(['customer', 'user'])->first();
         $fullFillOrder['order'] = $order;
         
         $manifestPDF = new ManifestPDF();
         $manifestPDF->order_id = $request->order_id;
         $manifestPDF->customer_id = $order->customer_id;

        $pdfArray = array();
        for ($i = 0; $i < count($pdfTypes); $i++) {
            $fullFillOrder['pdfType']=$pdfTypes[$i];
            $pdf = \App::make('dompdf.wrapper');

            $customPaper = array(0,0,900,1300);
            $pdf->setPaper($customPaper);
            $pdf->loadView('manifest.index', ['data' => $fullFillOrder]);

            $fullFillOrder['pdfType'] = $pdfTypes[$i];
            $output = $pdf->output();
            // return $pdf->stream();
            $pdfPath = public_path().'/manifest/pdfs/'.time().'.pdf';
            $abPDFPath  ='manifest/pdfs/'.time().'.pdf';
            file_put_contents($pdfPath, $output);
           switch ($pdfTypes[$i]) {
            case 'Generator':
                $manifestPDF->generator = $abPDFPath;
                break;
            case 'Transporter':
                $manifestPDF->transporter = $abPDFPath;
                break;
            case 'Processor':
                $manifestPDF->processor = $abPDFPath;
                break;
            case 'Disposal':
                $manifestPDF->disposal = $abPDFPath;
                break;
            case 'Original Generator':
                $manifestPDF->original_generator = $abPDFPath;
                break;
            
            default:
                break;
           }
        //  return view('manifest.index');
    }
    $manifestPDF->save();


         return redirect('/');
    }

    /**
     * Display the specified resource.
     */
    public function show(FullFillOrder $fullFillOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FullFillOrder $fullFillOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FullFillOrder $fullFillOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FullFillOrder $fullFillOrder)
    {
        //
    }
}
