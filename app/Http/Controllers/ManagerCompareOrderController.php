<?php

namespace App\Http\Controllers;

use App\Models\ManagerCompareOrder;
use App\Models\Order;
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
 
         if (!empty($passangerTireTypes) && count($passangerTireTypes)) {
             foreach ($passangerTireTypes as $key => $value) {
                 $availablePassangerTireTypesArr[] = [
                     $value => $request[$value]
                 ];
             }
         }
 
 
         //TRUCK TIRES TYPE
 
         $truckTireTypes = $request->truck_tyres_type;
         $availableTruckTireTypesArr = [];
 
         if (!empty($truckTireTypes) && count($truckTireTypes)) {
             foreach ($truckTireTypes as $key => $value) {
                 $availableTruckTireTypesArr[] = [
                     $value => $request[$value]
                 ];
             }
         }
 
         // dd($availableTruckTireTypesArr);
 
         $agriTireTypes = $request->agri_tires_type;
         $availableAgriTireTypesArr = [];
 
         if (!empty($agriTireTypes) && count($agriTireTypes)) {
             foreach ($agriTireTypes as $key => $value) {
                 $availableAgriTireTypesArr[] = [
                     $value => $request[$value]
                 ];
             }
         }
 
 
         $otrTireTypes = $request->otr_tires_type;
         $availableOtrTireTypesArr = [];
 
         if (!empty($otrTireTypes) && count($otrTireTypes)) {
             foreach ($otrTireTypes as $key => $value) {
                 $availableOtrTireTypesArr[] = [
                     $value => $request[$value]
                 ];
             }
         }


         ManagerCompareOrder::create([
            'type_of_passenger' => count($availablePassangerTireTypesArr) ? json_encode($availablePassangerTireTypesArr) : null,
            'type_of_agri_tyre' => count($availableAgriTireTypesArr) ? json_encode($availableAgriTireTypesArr) : null,
            'type_of_truck_tyre' => count($availableTruckTireTypesArr) ? json_encode($availableTruckTireTypesArr) : null,
            'type_of_other' => count($availableOtrTireTypesArr) ? json_encode($availableOtrTireTypesArr) : null,
            'order_id' => $request->order_id ?? null,
        ]);

        $order = Order::find($request->order_id);
        if($order){
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

    public function generateCountSheet($id){
        $order = Order::where('id',$id)->with(['compared','fulfilled'])->latest()->first();
        if($order){
            $pdf = \App::make('dompdf.wrapper');

            $customPaper = array(0,0,1000,2000);
                        $pdf->setPaper($customPaper);
            $pdf->loadView('countsheet.index', ['data' => $order]);

    
            // $output = $pdf->output();
            return $pdf->stream();
        }

    }
}
