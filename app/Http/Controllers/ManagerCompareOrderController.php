<?php

namespace App\Http\Controllers;

use App\Models\CustomerPricing;
use App\Models\ManagerCompareOrder;
use App\Models\ManifestPDF;
use App\Models\Order;
use App\Models\StateWeight;
use Illuminate\Http\Request;

class ManagerCompareOrderController extends Controller
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
        //STORING TIRES TYPE IN JSON STRING

        $passangerTireTypes = $request->passanger_tyres_type;
        $availablePassangerTireTypesArr = [];
        $reusePassangerTireTypesArr = [];

        if (!empty($passangerTireTypes) && count($passangerTireTypes)) {
            foreach ($passangerTireTypes as $key => $value) {
                $input = $request[$value];
                $values = explode(" ", $input);
                $values = array_map('intval', $values);
                $sum = array_sum($values);
                $availablePassangerTireTypesArr[] = [
                    $value => $sum
                ];
            }

            foreach ($passangerTireTypes as $key => $value) {
                $concatInput = "reuse_".$value;
                $reusePassangerTireTypesArr[] = [
                    $concatInput => $request[$concatInput]
                ];
            }

            // dd($reusePassangerTireTypesArr);
        }


        //TRUCK TIRES TYPE

        $truckTireTypes = $request->truck_tyres_type;
        $availableTruckTireTypesArr = [];
        $reuseTruckTireTypesArr = [];

        if (!empty($truckTireTypes) && count($truckTireTypes)) {
            foreach ($truckTireTypes as $key => $value) {
                $input = $request[$value];
                $values = explode(" ", $input);
                $values = array_map('intval', $values);
                $sum = array_sum($values);
                $availableTruckTireTypesArr[] = [
                    $value => $sum
                ];
            }

            foreach ($truckTireTypes as $key => $value) {
                $concatInput = "reuse_".$value;
                $reuseTruckTireTypesArr[] = [
                    $concatInput => $request[$concatInput]
                ];
            }
        }


        $agriTireTypes = $request->agri_tires_type;
        $availableAgriTireTypesArr = [];
        $reuseAgriTireTypesArr = [];

        if (!empty($agriTireTypes) && count($agriTireTypes)) {
            foreach ($agriTireTypes as $key => $value) {
                $input = $request[$value];
                $values = explode(" ", $input);
                $values = array_map('intval', $values);
                $sum = array_sum($values);
                $availableAgriTireTypesArr[] = [
                    $value => $sum
                ];
            }

            foreach ($agriTireTypes as $key => $value) {
                $concatInput = "reuse_".$value;
                $reuseAgriTireTypesArr[] = [
                    $concatInput => $request[$concatInput]
                ];
            }
        }



        $otrTireTypes = $request->otr_tires_type;
        $availableOtrTireTypesArr = [];
        $reuseOTRTireTypesArr = [];

        if (!empty($otrTireTypes) && count($otrTireTypes)) {
            foreach ($otrTireTypes as $key => $value) {
                $input = $request[$value];
                $values = explode(" ", $input);
                $values = array_map('intval', $values);
                $sum = array_sum($values);
                $availableOtrTireTypesArr[] = [
                    $value => $sum
                ];
            }

            foreach ($otrTireTypes as $key => $value) {
                $concatInput = "reuse_".$value;
                $reuseOTRTireTypesArr[] = [
                    $concatInput => $request[$concatInput]
                ];
            }
        }


        ManagerCompareOrder::create([
            'type_of_passenger' => count($availablePassangerTireTypesArr) ? json_encode($availablePassangerTireTypesArr) : null,
            'type_of_agri_tyre' => count($availableAgriTireTypesArr) ? json_encode($availableAgriTireTypesArr) : null,
            'type_of_truck_tyre' => count($availableTruckTireTypesArr) ? json_encode($availableTruckTireTypesArr) : null,
            'type_of_other' => count($availableOtrTireTypesArr) ? json_encode($availableOtrTireTypesArr) : null,
            'reuse_type_of_passenger' => count($reusePassangerTireTypesArr) ? json_encode($reusePassangerTireTypesArr) : null,
            'reuse_type_of_truck_tyre' => count($reuseTruckTireTypesArr) ? json_encode($reuseTruckTireTypesArr) : null,
            'reuse_type_of_agri_tyre' => count($reuseAgriTireTypesArr) ? json_encode($reuseAgriTireTypesArr) : null,
            'reuse_type_of_other' => count($reuseOTRTireTypesArr) ? json_encode($reuseOTRTireTypesArr) : null,
            'order_id' => $request->order_id ?? null,
        ]);

        $order = Order::find($request->order_id);
        if ($order) {
            $order->status = 'compared';
            $order->update();
        }

        return redirect('fulfilled-orders')->with('success', 'Your Counting is saved!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ManagerCompareOrder $managerCompareOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ManagerCompareOrder $managerCompareOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ManagerCompareOrder $managerCompareOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ManagerCompareOrder $managerCompareOrder)
    {
        //
    }

    public function generateCountSheet($id)
    {
        $order = Order::where('id', $id)->with(['compared', 'fulfilled', 'customer', 'driver', 'tdfOrder', 'trailerSwapOrder', 'stateWeight', 'steel'])->latest()->first();
        $customerPricing = CustomerPricing::whereCustomerId($order->customer_id)->first();

        $pdf = \App::make('dompdf.wrapper');
        $order['customerPricing'] = $customerPricing;
        $output = null;

        if ($order && $order->load_type == 'box_truck_route') {
            $customPaper = array(0, 0, 1000, 2000);
            $pdf->setPaper($customPaper);

            $pdf->loadView('countsheet.index', ['data' => $order]);
            $output = $pdf->output();
            // return $pdf->stream();
        } else if ($order && $order->load_type == 'tdf') {
            $pdf->setPaper('landscape');

            $pdf->loadView('countsheet.tdf', ['data' => $order]);
            $output = $pdf->output();
            // return $pdf->stream();
        } else if ($order && $order->load_type == 'trailer_swap') {
            $pdf->setPaper('landscape');

            $pdf->loadView('countsheet.trailerswap', ['data' => $order]);
            $output = $pdf->output();
            // return $pdf->stream();
        } else if ($order && $order->load_type == 'state') {
            $isStateWeight = StateWeight::where('order_id', $order->id)->exists();
            if ($isStateWeight) {
                $pdf->setPaper('landscape');
                $pdf->loadView('countsheet.state_weight', ['data' => $order]);
                $output = $pdf->output();
                // return $pdf->stream();
            }
        } else if ($order && $order->load_type == 'steel') {
            $pdf->setPaper('landscape');
            $pdf->loadView('countsheet.steel', ['data' => $order]);
            $output = $pdf->output();
            // return $pdf->stream();
        }

        $pdfPath = public_path() . '/countsheets/' . time() . '.pdf';
        $abPDFPath  = 'countsheets/' . time() . '.pdf';
        file_put_contents($pdfPath, $output);

        $manifestPDF = ManifestPDF::where('order_id', $order->id)->latest()->first();
        if($manifestPDF){
            $manifestPDF->count_sheet = $abPDFPath;
            $manifestPDF->update();
        }else{
            $manifestPDF = new ManifestPDF();
            $manifestPDF->order_id = $order->id;
            $manifestPDF->customer_id = $order->customer_id;
            $manifestPDF->count_sheet = $abPDFPath;
            $manifestPDF->save();
        }
       return $pdf->stream();
    }

    public function generateWeightSheet($id)
    {
        $order = Order::where('id', $id)->with(['fulfilled', 'customer', 'driver'])->latest()->first();

        $pdf = \App::make('dompdf.wrapper');

        if ($order && $order->load_type == 'box_truck_route') {
            $customPaper = array(0, 0, 600, 1400);
            $pdf->setPaper($customPaper);

            $pdf->loadView('weightsheet.create', ['data' => $order]);
            // $output = $pdf->output();
            return $pdf->stream();
        }
    }
}
