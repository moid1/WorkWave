<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomPricing;
use App\Models\Order;
use App\Models\Routing;
use App\Models\Trailers;
use App\Models\TrailerSwapOrder;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function trailerSwapReport(Request $request)
    {
        $graded = [];
        $notGraded = [];

        // Fetch orders with relationships
        $orders = Order::where('load_type', 'trailer_swap')->with(['trailerSwapOrder', 'customer'])->get();

        // Group orders based on the grading type
        foreach ($orders as $order) {
            if ($order->customer->trailer_grading_type == 'trailers_to_grade') {
                $graded[] = $order;
            } else if ($order->customer->trailer_grading_type == 'trailers_green_light') {
                $notGraded[] = $order;
            }
        }

        // Get all trailers and group them by location
        $trailers = Trailers::with('customerData')->get()->groupBy('trailer_going');
        $customers = Customer::select('id', 'business_name')->get();
        return view('reports.trailer', compact('graded', 'notGraded', 'customers', 'trailers'));
    }

    public function getOrdersByTruckRouted(Request $request)
    {
        $driver_id = $request->driver_id;
        if (!$driver_id) {
            return;
        }

        $routing = Routing::where('driver_id', $driver_id)->latest()->first();
        if ($routing) {
            $orderIds = explode(',', $routing->order_ids);

            // Fetch orders from database
            $orders = Order::whereIn('id', $orderIds)->with('customer')->get();
            return view('truck.orders', compact('orders'));

        }
    }

    public function getSearachTrailerView()
    {
        $trailers = [];
        return view('trailer.search', compact('trailers'));
    }

    public function getSearchTrailerData(Request $request)
    {
        $trailerNo = $request->trailer_no;
        $trailers = Trailers::where('name', $trailerNo)->with('customerData')->first();
        return view('trailer.search', compact('trailers'));


    }

    public function updateTrailerData(Request $request)
    {
        $trailerId = $request->trailer_id;
        // $trailerData = TrailerSwapOrder::findOrFail($trailerId);
        // if($trailerData){
        //     $trailerData->status = $request->statusData;
        //     $trailerData->location = $request->location;
        //     $trailerData->update();
        // }

        $trailer = Trailers::find($trailerId);
        if ($trailer) {
            if ($request->status) {
                $trailer->status = $request->status;
            }
            if ($request->location) {
                $trailer->location = $request->location;
            }
            if ($request->trailer_going) {
                $trailer->trailer_going = $request->trailer_going;
            }
            if ($request->customer) {
                $trailer->customer = $request->customer;
            }
            $trailer->save();
        }

        return back()->with('success', 'Data updated successfully');
    }


    public function generateInhouseManifest()
    {
        return view('custom-manifest.create');
    }

    public function generateInhouseManifestPost(Request $request)
    {
        $pdfTypes = ['Generator'];
        // $pdfTypes = ['Generator'];



        //STORING TIRES TYPE IN JSON STRING

        $passangerTireTypes = $request->passanger_tyres_type;
        $availablePassangerTireTypesArr = [];

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
        }



        //TRUCK TIRES TYPE

        $truckTireTypes = $request->truck_tyres_type;
        $availableTruckTireTypesArr = [];

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
        }

        // dd($availableTruckTireTypesArr);

        $agriTireTypes = $request->agri_tires_type;
        $availableAgriTireTypesArr = [];

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
        }


        $otrTireTypes = $request->otr_tires_type;
        $availableOtrTireTypesArr = [];

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
        }

        // dd($availableOtrTireTypesArr);



        // Initialize the array with the provided data
        $fullFillOrder = [
            'type_of_passenger' => count($availablePassangerTireTypesArr) ? json_encode($availablePassangerTireTypesArr) : null,
            'type_of_agri_tyre' => count($availableAgriTireTypesArr) ? json_encode($availableAgriTireTypesArr) : null,
            'type_of_truck_tyre' => count($availableTruckTireTypesArr) ? json_encode($availableTruckTireTypesArr) : null,
            'type_of_other' => count($availableOtrTireTypesArr) ? json_encode($availableOtrTireTypesArr) : null,
            'order_id' => $request->order_id ?? null,
            'processor_reg_no' => $request->company_reg ?? null,
            'customer_signature' => $file ?? null,
            'driver_signature' => $driverSignFile ?? null,
            'cheque_no' => $request->cheque_no ?? null,
            'left_over' => $request->tires_left ?? null
        ];
        // dd($fullFillOrder);

        // Add 'customerPricing' as an array element
        $customerPricing = CustomPricing::first()->toArray();
        $fullFillOrder['customerPricing'] = $customerPricing;  // Store the customerPricing object in the array

        // Add 'orderRequest' as an array element
        $fullFillOrder['orderRequest'] = $request->all();  // Store the entire request data in the array
        // Now $fullFillOrder has both object and array elements correctly
// dd($fullFillOrder);

        for ($i = 0; $i < count($pdfTypes); $i++) {
            $pdf = \App::make('dompdf.wrapper');

            $customPaper = array(0, 0, 900, 1300);
            $pdf->setPaper($customPaper);
            $pdf->loadView('custom-manifest.manifest', ['data' => $fullFillOrder]);

            $fullFillOrder['pdfType'] = $pdfTypes[$i];
            $output = $pdf->output();
            $test = $pdf;
            // return $pdf->stream();
            $pdfPath = public_path() . '/manifest/pdfs/' . time() . '.pdf';
            // $abPDFPath = 'manifest/pdfs/' . time() . '.pdf';
            // file_put_contents($pdfPath, $output);

            //  return view('manifest.index');
        }
        return $test->stream();

        // return redirect('/driver-orders')->with('success', 'Manifest has been created successfully');
    }
}
