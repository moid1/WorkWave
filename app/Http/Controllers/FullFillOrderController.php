<?php

namespace App\Http\Controllers;

use App\Models\CompanyReg;
use App\Models\FulfilTyre;
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
        $registrationNos = CompanyReg::all();
        return view('orders.fulfill.create', compact('order', 'registrationNos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $pdfTypes = ['Generator', 'Transporter', 'Processor', 'Disposal', 'Original Generator'];
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


        $fullFillOrder =  FullFillOrder::create([
            'no_of_passenger' => $request->passenger_tire ?? null,
            'no_of_agri_tyre' => $request->agri_tire ?? null,
            'no_of_truck_tyre' => $request->truck_tire ?? null,
            'no_of_other' => $request->other_tire ?? null,
            'order_id' => $request->order_id ?? null,
            'processor_reg_no' => $request->company_reg ?? null,
            'customer_signature' => $file ?? null,
            'start_weight' => $request->start_weight ?? null,
            'end_weight' => $request->end_weight ?? null,
            'cheque_no' => $request->cheque_no ?? null
        ]);

        $totalWeightsObject = $this->getTotalWeight($request);


        $fulfilTyres = FulfilTyre::create([
            'full_fill_orders_id' => $fullFillOrder->id,
            'lawnmowers_atvmotorcycle' => $request->lawnmowers_atvmotorcycle ?? null,
            'lawnmowers_atvmotorcyclewithrim' => $request->lawnmowers_atvmotorcyclewithrim ?? null,
            'passanger_lighttruck' => $request->passanger_lighttruck ?? null,
            'passanger_lighttruckwithrim' => $request->passanger_lighttruckwithrim ?? null,
            'semi_truck' => $request->semi_truck ?? null,
            'semi_super_singles' => $request->semi_super_singles ?? null,
            'semi_truck_with_rim' => $request->semi_truck_with_rim ?? null,
            'totalPassangerTiresWeight' => $totalWeightsObject['totalPassangerTiresWeight'] ?? null,
            'totalTruckTiresWeight' => $totalWeightsObject['totalTruckTiresWeight'] ?? null,
        ]);

        $order = Order::where('id', $request->order_id)->with(['customer', 'user'])->first();
        $order->status = 'fulfilled';

        $order->update();
        $fullFillOrder['order'] = $order;
        $fullFillOrder['fulfilTyres'] = $fulfilTyres;

        $manifestPDF = new ManifestPDF();
        $manifestPDF->order_id = $request->order_id;
        $manifestPDF->customer_id = $order->customer_id;

        $pdfArray = array();
        for ($i = 0; $i < count($pdfTypes); $i++) {
            $fullFillOrder['pdfType'] = $pdfTypes[$i];
            $pdf = \App::make('dompdf.wrapper');

            $customPaper = array(0, 0, 900, 1300);
            $pdf->setPaper($customPaper);
            $pdf->loadView('manifest.index', ['data' => $fullFillOrder]);

            $fullFillOrder['pdfType'] = $pdfTypes[$i];
            $output = $pdf->output();
            return $pdf->stream();
            $pdfPath = public_path() . '/manifest/pdfs/' . time() . '.pdf';
            $abPDFPath  = 'manifest/pdfs/' . time() . '.pdf';
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


        return redirect('/')->with('success', 'Manifest has been created successfully');
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

    public function getFullFilledOrders()
    {
        $fullFilledOrderStatus = ['error-compared', 'fulfilled'];
        $orders = Order::whereIn('status', $fullFilledOrderStatus)->get();
        return view('orders.fulfill.index', compact('orders'));
    }

    public function getTotalWeight($request)
    {
        // 'full_fill_orders_id' => $fullFillOrder->id,
        // 'lawnmowers_atvmotorcycle' => $request->lawnmowers_atvmotorcycle ?? null,
        // 'lawnmowers_atvmotorcyclewithrim' => $request->lawnmowers_atvmotorcyclewithrim ?? null,
        // 'passanger_lighttruck' => $request->passanger_lighttruck ?? null,
        // 'passanger_lighttruckwithrim' => $request->passanger_lighttruckwithrim ?? null,
        // 'semi_truck' => $request->semi_truck ?? null,
        // 'semi_super_singles' => $request->semi_super_singles ?? null,
        // 'semi_truck_with_rim' => $request->semi_truck_with_rim ?? null,
        $lawnmowers_atvmotorcycle = 15;
        $lawnmowers_atvmotorcycle_with_rim = 15;
        $passanger_lighttruck = 25;
        $passanger_lighttruckwithrim = 25;
        $semi_truck = 110;
        $semi_super_singles = 125;
        $semi_truck_with_rim = 110;

        $totalPassangerTiresWeight = 0;
        $totalTruckTiresWeight = 0;

        $totalPassangerTiresWeight = ($request->lawnmowers_atvmotorcycle * $lawnmowers_atvmotorcycle) +
            ($request->lawnmowers_atvmotorcyclewithrim * $lawnmowers_atvmotorcycle_with_rim) +
            ($request->passanger_lighttruck * $passanger_lighttruck) +
            ($request->passanger_lighttruckwithrim * $passanger_lighttruckwithrim);

        $totalTruckTiresWeight = ($request->semi_truck * $semi_truck) +
            ($request->semi_super_singles * $semi_super_singles) +
            ($request->semi_truck_with_rim) * $semi_truck_with_rim;

        return [
            'totalPassangerTiresWeight' => $totalPassangerTiresWeight,
            'totalTruckTiresWeight' => $totalTruckTiresWeight
        ];
    }

    public function compareOrder($id)
    {
        $order = Order::find($id);
        return view('manager.compare.compare', compact('order'));
    }

    public function compareOrderPost(Request $request)
    {
        $order = Order::find($request->order_id);
        $fullFill = FullFillOrder::where('order_id', $order->id)->latest()->first();
        $tyreFulFil = FulfilTyre::where('full_fill_orders_id', $fullFill->id)->first();
        $isEveryThingOK = true;
        if ($order && $fullFill) {
            if ($request->passenger_tire != $fullFill->no_of_passenger) {
                $isEveryThingOK = false;
            }
            if ($request->lawnmowers_atvmotorcycle != $tyreFulFil->lawnmowers_atvmotorcycle) {
                $isEveryThingOK = false;
            }
            if ($request->lawnmowers_atvmotorcyclewithrim != $tyreFulFil->lawnmowers_atvmotorcyclewithrim) {
                $isEveryThingOK = false;
            }
            if ($request->passanger_lighttruck != $tyreFulFil->passanger_lighttruck) {
                $isEveryThingOK = false;
            }
            if ($request->passanger_lighttruckwithrim != $tyreFulFil->passanger_lighttruckwithrim) {
                $isEveryThingOK = false;
            }
            if ($request->truck_tire != $fullFill->no_of_truck_tyre) {
                $isEveryThingOK = false;
            }

            if ($request->semi_truck != $tyreFulFil->semi_truck) {
                $isEveryThingOK = false;
            }
            if ($request->semi_super_singles != $tyreFulFil->semi_super_singles) {
                $isEveryThingOK = false;
            }
            if ($request->semi_truck_with_rim != $tyreFulFil->semi_truck_with_rim) {
                $isEveryThingOK = false;
            }
        }

        if($isEveryThingOK){
            $order->status = 'compared';
            $order->update();
            return back()->with('success', 'Tire Counting is Same');
        }else{
            $order->status = 'error-compared';
            $order->update();
            return back()->with('error','Tire Counting is not same');
        }
    }
}
