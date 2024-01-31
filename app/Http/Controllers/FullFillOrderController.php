<?php

namespace App\Http\Controllers;

use App\Models\CompanyReg;
use App\Models\CustomerPricing;
use App\Models\FullFillOrder;
use App\Models\ManifestPDF;
use App\Models\Order;
use App\Models\StateWeight;
use App\Models\SteelOrder;
use App\Models\TdfOrder;
use App\Models\TrailerSwapOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use DataTables;
use Illuminate\Support\Facades\Auth;

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
        switch ($order->load_type) {
            case 'box_truck_route':
                return view('orders.fulfill.create', compact('order', 'registrationNos'));
            case 'trailer_swap':
                return view('orders.fulfill.trailer.create', compact('order'));
            case 'state':
                return view('orders.fulfill.state.select', compact('order'));
            case 'tdf':
                return view('orders.fulfill.tdf.create', compact('order'));
            case 'steel':
                return view('orders.fulfill.steel.create', compact('order'));
            default:
                # code...
                break;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $pdfTypes = ['Generator', 'Transporter', 'Processor', 'Disposal', 'Original Generator'];
        // $pdfTypes = ['Generator'];
        $folderPath = 'signatures/';

        $image_parts = explode(";base64,", $request->signed);
        $driverSign = explode(";base64,", $request->driver_signed);

        $image_type_aux = explode("image/", $image_parts[0]);
        $driver_sign_aux = explode("image/", $driverSign[0]);

        if (!$image_type_aux[0] != '') {
            return back()->with('error', 'Signature Required');
        }
        if (!$driver_sign_aux[0] != '') {
            return back()->with('error', 'Driver Signature Required');
        };

        $image_type = $image_type_aux[1];
        $driver_image_type =  $driver_sign_aux[1];


        $image_base64 = base64_decode($image_parts[1]);
        $driver_base64 = base64_decode($driverSign[1]);

        $file = $folderPath . uniqid() . '.' . $image_type;
        file_put_contents($file, $image_base64);
        // DRIVER SIGN
        $driverSignFile = $folderPath . uniqid() . '.' . $driver_image_type;
        file_put_contents($driverSignFile, $driver_base64);

        //STORING TIRES TYPE IN JSON STRING

        $passangerTireTypes = $request->passanger_tyres_type;
        $availablePassangerTireTypesArr = [];

        if (!empty($passangerTireTypes) && count($passangerTireTypes)) {
            foreach ($passangerTireTypes as $key => $value) {
                $input =  $request[$value];
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
                $input =  $request[$value];
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
                $input =  $request[$value];
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
                $input =  $request[$value];
                $values = explode(" ", $input);
                $values = array_map('intval', $values);
                $sum = array_sum($values);
                $availableOtrTireTypesArr[] = [
                    $value => $sum
                ];
            }
        }




        $fullFillOrder =  FullFillOrder::create([
            'type_of_passenger' => count($availablePassangerTireTypesArr) ? json_encode($availablePassangerTireTypesArr) : null,
            'type_of_agri_tyre' => count($availableAgriTireTypesArr) ? json_encode($availableAgriTireTypesArr) : null,
            'type_of_truck_tyre' => count($availableTruckTireTypesArr) ? json_encode($availableTruckTireTypesArr) : null,
            'type_of_other' => count($availableOtrTireTypesArr) ? json_encode($availableOtrTireTypesArr) : null,
            'order_id' => $request->order_id ?? null,
            'processor_reg_no' => $request->company_reg ?? null,
            'customer_signature' => $file ?? null,
            'driver_signature' => $driverSignFile ?? null,
            'cheque_no' => $request->cheque_no ?? null
        ]);

      


        $order = Order::where('id', $request->order_id)->with(['customer', 'user'])->first();
        if ($request->want_back == 'yes') {
            Order::create([
                'customer_id' => $order->customer->id,
                'user_id' => Auth::id(),
                'notes' =>  $request['tires_left'] ? 'No of Tires left over '. $request['tires_left'] : 'N/A',
                'load_type' => 'box_truck_route',
                'driver_id' => Auth::id()
            ]);
        }


        $customerPricing = CustomerPricing::where('customer_id', $order->customer->id)->first();

        $order->status = 'fulfilled';
        $order->payment_type = $request->payment_type ?? null;

        $order->update();
        $fullFillOrder['order'] = $order;
        $fullFillOrder['customerPricing'] = $customerPricing;

        $manifestPDF = new ManifestPDF();
        $manifestPDF->order_id = $request->order_id;
        $manifestPDF->customer_id = $order->customer_id;

        for ($i = 0; $i < count($pdfTypes); $i++) {
            $fullFillOrder['pdfType'] = $pdfTypes[$i];
            $pdf = \App::make('dompdf.wrapper');

            $customPaper = array(0, 0, 900, 1500);
            $pdf->setPaper($customPaper);
            $pdf->loadView('manifest.index', ['data' => $fullFillOrder]);

            $fullFillOrder['pdfType'] = $pdfTypes[$i];
            $output = $pdf->output();
            $test = $pdf;
            // return $pdf->stream();
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
        return $test->stream();

        return redirect('/driver-orders')->with('success', 'Manifest has been created successfully');
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

    public function getFullFilledOrders(Request $request)
    {
        $fullFilledOrderStatus = ['error-compared', 'fulfilled'];
        $orders = Order::whereIn('status', $fullFilledOrderStatus)->where('load_type', '<>', 'tdf')->get();

        if ($request->ajax()) {
            $data = Order::whereIn('status', $fullFilledOrderStatus)->where('load_type', '<>', 'tdf')->get();
            if ($request->filled('from_date') && $request->filled('to_date')) {
                $fromDate = Carbon::parse($request->from_date);
                $toDate = Carbon::parse($request->to_date)->endOfDay();
                $data = $data->whereBetween('created_at', [$fromDate, $toDate]);
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('id', function ($row) {
                    return $row->id;
                })
                ->editColumn('business_name', function ($row) {
                    if ($row->customer->business_name) {
                        return $row->customer->business_name;
                    }
                    return 'N/A';
                })
                ->editColumn('created_by', function ($row) {
                    if ($row->user->name) {
                        return $row->user->name;
                    }
                    return 'N/A';
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('M d Y');
                })
              
                ->editColumn('driver', function ($row) {
                    if ($row->driver)
                        return $row->driver->name;
                    return 'N/A';
                })

                ->editColumn('status', function ($row) {
                    if ($row->driver)
                        return $row->status;
                    return 'N/A';
                })
                ->editColumn('action', function ($row) {
                    $route = route("compare.order", $row->id);
                return '<a href=' . $route . ' class="update_driver"> <i class="mdi mdi-compare" ></i></a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('orders.fulfill.index', compact('orders'));
    }



    public function compareOrder($id)
    {
        $order = Order::find($id);
        return view('manager.compare.compare', compact('order'));
    }


    public function loadByWeight($id)
    {
        $order = Order::find($id);
        return view('orders.fulfill.state.loadweight', compact('order'));
    }

    public function loadByTire($id)
    {
        $order = Order::where('id', $id)->with(['customer', 'user'])->first();
        $registrationNos = CompanyReg::all();
        return view('orders.fulfill.create', compact('order', 'registrationNos'));
    }

    public function getTotalWeightOfOrder($todayOrder)
    {
        $typesOfPassangerTires = !empty($todayOrder->fulfilled->type_of_passenger) ? json_decode($todayOrder->fulfilled->type_of_passenger, true) : [];
        $typesOfTruckTires = !empty($todayOrder->fulfilled->type_of_truck_tyre) ? json_decode($todayOrder->fulfilled->type_of_truck_tyre, true) : [];
        $typesOfAgriTires = !empty($todayOrder->fulfilled->type_of_agri_tyre) ? json_decode($todayOrder->fulfilled->type_of_agri_tyre, true) : [];
        $typesOfOtherTires = !empty($todayOrder->fulfilled->type_of_other) ? json_decode($todayOrder->fulfilled->type_of_other, true) : [];

        //for single passanger
        $lawnmowers_atvmotorcycle = 0;
        $lawnmowers_atvmotorcyclewithrim = 0;
        $passanger_lighttruck = 0;
        $passanger_lighttruckwithrim = 0;
        foreach ($typesOfPassangerTires as $item) {
            foreach ($item as $key => $value) {
                if ($key == 'lawnmowers_atvmotorcycle') {
                    $lawnmowers_atvmotorcycle = $value;
                } elseif ($key == 'lawnmowers_atvmotorcyclewithrim') {
                    $lawnmowers_atvmotorcyclewithrim = $value;
                } elseif ($key == 'passanger_lighttruck') {
                    $passanger_lighttruck = $value;
                } elseif ($key == 'passanger_lighttruckwithrim') {
                    $passanger_lighttruckwithrim = $value;
                }
            }
        }



        //for single truck
        $semi_truck = 0;
        $semi_super_singles = 0;
        $semi_truck_with_rim = 0;
        foreach ($typesOfTruckTires as $item) {
            foreach ($item as $key => $value) {
                if ($key == 'semi_truck') {
                    $semi_truck = $value;
                } elseif ($key == 'semi_super_singles') {
                    $semi_super_singles = $value;
                } elseif ($key == 'semi_truck_with_rim') {
                    $semi_truck_with_rim = $value;
                }
            }
        }

        // for single agri

        $ag_med_truck_19_5_skid_steer = 0;
        $ag_med_truck_19_5_with_rim = 0;
        $farm_tractor_last_two_digits = 0;

        foreach ($typesOfAgriTires as $item) {
            foreach ($item as $key => $value) {
                if ($key == 'ag_med_truck_19_5_skid_steer') {
                    $ag_med_truck_19_5_skid_steer = $value;
                } elseif ($key == 'ag_med_truck_19_5_with_rim') {
                    $ag_med_truck_19_5_with_rim = $value;
                } elseif ($key == 'farm_tractor_last_two_digits') {
                    $farm_tractor_last_two_digits = $value;
                }
            }
        }

        $driver_15_5_24 = 0;
        $driver_17_5_25 = 0;
        $driver_20_5_25 = 0;
        $driver_23_5_25 = 0;
        $driver_26_5_25 = 0;
        $driver_29_5_25 = 0;
        $driver_24_00R35 = 0;
        $driver_13_00_24 = 0;
        $driver_14_00_24 = 0;
        $driver_19_5L_24 = 0;

        foreach ($typesOfOtherTires as $item) {
            foreach ($item as $key => $value) {
                switch ($key) {
                    case '15_5_24':
                        $driver_15_5_24 = $value;
                        break;
                    case '17_5_25':
                        $driver_17_5_25 = $value;
                        break;
                    case '20_5_25':
                        $driver_20_5_25 = $value;
                        break;
                    case '23_5_25':
                        $driver_23_5_25 = $value;
                        break;
                    case '26_5_25':
                        $driver_26_5_25 = $value;
                        break;
                    case '29_5_25':
                        $driver_29_5_25 = $value;
                        break;
                    case '24_00R35':
                        $driver_24_00R35 = $value;
                        break;
                    case '13_00_24':
                        $driver_13_00_24 = $value;
                        break;
                    case '14_00_24':
                        $driver_14_00_24 = $value;
                        break;
                    case '19_5L_24':
                        $driver_19_5L_24 = $value;
                        break;
                    default:
                        # code...
                        break;
                }
            }
        }

        $passangerTotal = $passanger_lighttruckwithrim * 25 + $passanger_lighttruck * 15 + $lawnmowers_atvmotorcyclewithrim * 25 + $lawnmowers_atvmotorcycle * 15;
        $truckTotal = $semi_truck * 110 + $semi_super_singles * 110 + $semi_truck_with_rim * 125;
        $agriTotal = $farm_tractor_last_two_digits * 5 + $ag_med_truck_19_5_with_rim * 60 + $ag_med_truck_19_5_skid_steer * 60;
        $otherTotal = $driver_19_5L_24 * 192 + $driver_14_00_24 * 293 + $driver_13_00_24 * 158 + $driver_24_00R35 * 1816 + $driver_29_5_25 * 1279 + $driver_26_5_25 * 1000 + $driver_23_5_25 * 551 + $driver_20_5_25 * 330 + $driver_17_5_25 * 300 + $driver_15_5_24 * 158;
        $allTotal  = $passangerTotal + $truckTotal + $agriTotal + $otherTotal;
        return $allTotal;
    }


    public function tdfOrderCreate(Request $request)
    {

        $pdfTypes = ['Generator', 'Transporter', 'Processor', 'Disposal', 'Original Generator'];
        // $pdfTypes = ['Generator'];
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
            'cx_signature' => $file
        ]);

        //TODO: NEED TO FETCH TRAILERSWAP and BOXTRUCK ORDERS FOR CURRENT DAY.
        $today = Carbon::now()->toDateString();
        $todayOrders = Order::whereDate('created_at', $today)
            ->whereIn('load_type', ['box_truck_route', 'trailer_swap'])
            ->where('is_pick_tdf', false)
            ->with('fulfilled')->get();
        $totalWeightTillOrder = 0;
        $tdfAssignedOrder = [];
        // Need to get total Weight for 40K
        foreach ($todayOrders as $key => $todayOrder) {
            if ($todayOrder->load_type == 'box_truck_route' && !empty($todayOrder->fulfilled)) {
                $lessThenWeight = abs((int) $request->start_weight) - ((int)$request->end_weight);
                if ($totalWeightTillOrder >= $lessThenWeight) {
                    break;
                }
                $totalWeightTillOrder += $this->getTotalWeightOfOrder($todayOrder);
                $todayOrder->load_value = $totalWeightTillOrder;

                $tdfAssignedOrder[] = $todayOrder->id;
                $todayOrder->is_pick_tdf = true;
                $todayOrder->update();
            }
        }

        $fullFillOrder = TdfOrder::updateOrCreate(['order_id' => $request->order_id], $request->except(['customer_id', 'signed']));
        $fullFillOrder->recyle_order =  implode(',', $tdfAssignedOrder);
        $fullFillOrder->update();

        $order = Order::where('id', $request->order_id)->with(['customer', 'user'])->first();

        $order->status = 'fulfilled';
        $order->payment_type = $request->payment_type ?? null;

        $order->update();
        $fullFillOrder['order'] = $order;
        $fullFillOrder['tdf'] = $fullFillOrder;
        $customerPricing = CustomerPricing::where('customer_id', $order->customer_id)->first();
        $fullFillOrder['customerPricing'] = $customerPricing;

        $manifestPDF = new ManifestPDF();
        $manifestPDF->order_id = $request->order_id;
        $manifestPDF->customer_id = $order->customer_id;
        $test = null;
        $fullFillOrder['todaysOrder'] = $todayOrders;
        for ($i = 0; $i < count($pdfTypes); $i++) {
            $fullFillOrder['pdfType'] = $pdfTypes[$i];
            $pdf = \App::make('dompdf.wrapper');

            $customPaper = array(0, 0, 900, 1300);
            $pdf->setPaper($customPaper);
            $pdf->loadView('manifest.tdf', ['data' => $fullFillOrder]);

            $fullFillOrder['pdfType'] = $pdfTypes[$i];
            $output = $pdf->output();
            $test = $pdf;

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
        // return $test->stream();

        return redirect('/driver-orders')->with('success', 'Manifest has been created successfully');
    }

    public function trailerSwapCreate(Request $request)
    {
        $pdfTypes = ['Generator', 'Transporter', 'Processor', 'Disposal', 'Original Generator'];
        // $pdfTypes = ['Generator'];
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
            'cx_signature' => $file
        ]);

        $fullFillOrder = TrailerSwapOrder::updateOrCreate(['order_id' => $request->order_id], $request->except(['customer_id', 'signed', 'payment_type', 'cheque_no', 'cash']));


        $order = Order::where('id', $request->order_id)->with(['customer', 'user'])->first();
        $customerPricing = CustomerPricing::where('customer_id', $order->customer_id)->first();

        $order->status = 'fulfilled';
        $order->payment_type = $request->payment_type ?? null;

        $order->update();
        $fullFillOrder['order'] = $order;
        $fullFillOrder['customerPricing'] = $customerPricing;

        $manifestPDF = new ManifestPDF();
        $manifestPDF->order_id = $request->order_id;
        $manifestPDF->customer_id = $order->customer_id;

        for ($i = 0; $i < count($pdfTypes); $i++) {
            $fullFillOrder['pdfType'] = $pdfTypes[$i];
            $pdf = \App::make('dompdf.wrapper');

            $customPaper = array(0, 0, 900, 1300);
            $pdf->setPaper($customPaper);
            $pdf->loadView('manifest.index', ['data' => $fullFillOrder]);

            $fullFillOrder['pdfType'] = $pdfTypes[$i];
            $output = $pdf->output();
            // return $pdf->stream();
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


        return redirect('/driver-orders')->with('success', 'Manifest has been created successfully');
    }

    public function stateByWeight(Request $request)
    {
        $pdfTypes = ['Generator', 'Transporter', 'Processor', 'Disposal', 'Original Generator'];
        // $pdfTypes = ['Generator'];
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
            'cx_signature' => $file
        ]);

        $fullFillOrder = StateWeight::updateOrCreate(['order_id' => $request->order_id], $request->except(['customer_id', 'signed', 'address']));


        $order = Order::where('id', $request->order_id)->with(['customer', 'user'])->first();
        $customerPricing = CustomerPricing::where('customer_id', $order->customer_id)->first();

        $order->status = 'compared';

        $order->update();
        $fullFillOrder['order'] = $order;
        $fullFillOrder['orderType'] = 'stateWeight';
        $fullFillOrder['stateOrder'] = $fullFillOrder;
        $fullFillOrder['customerPricing'] = $customerPricing;
        $manifestPDF = new ManifestPDF();
        $manifestPDF->order_id = $request->order_id;
        $manifestPDF->customer_id = $order->customer_id;
        $testPDF = null;
        for ($i = 0; $i < count($pdfTypes); $i++) {
            $fullFillOrder['pdfType'] = $pdfTypes[$i];
            $pdf = \App::make('dompdf.wrapper');

            $customPaper = array(0, 0, 900, 1300);
            $pdf->setPaper($customPaper);
            $pdf->loadView('manifest.index', ['data' => $fullFillOrder]);

            $fullFillOrder['pdfType'] = $pdfTypes[$i];
            $output = $pdf->output();
            $testPDF = $pdf;
            // return $pdf->stream();
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
        return $testPDF->stream();


        return redirect('/driver-orders')->with('success', 'Manifest has been created successfully');
    }

    public function steelOrderCreate(Request $request)
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
            'cx_signature' => $file
        ]);

        $fullFillOrder = SteelOrder::updateOrCreate(['order_id' => $request->order_id], $request->except(['customer_id', 'signed', 'address']));


        $order = Order::where('id', $request->order_id)->with(['customer', 'user'])->first();

        $order->status = 'compared';

        $order->update();

        return redirect('/driver-orders')->with('success', 'Order FulFilled Successfully');
    }

    // apis
    public function apiFulFillTDFOrder(Request $request)
    {

        try {
            //code...

            $pdfTypes = ['Generator', 'Transporter', 'Processor', 'Disposal', 'Original Generator'];
            $folderPath = 'signatures/';

            $image_parts = explode(";base64,", $request->signed);

            $image_type_aux = explode("image/", $image_parts[0]);

            if (!$image_type_aux[0] != '') {
                return response()->json([
                    'status' => false,
                    'message' => 'Signatures is required'
                ], 400);
            }


            $image_type = $image_type_aux[1];


            $image_base64 = base64_decode($image_parts[1]);

            $file = $folderPath . uniqid() . '.' . $image_type;
            file_put_contents($file, $image_base64);

            $request->merge([
                'cx_signature' => $file
            ]);

            //TODO: NEED TO FETCH TRAILERSWAP and BOXTRUCK ORDERS FOR CURRENT DAY.
            $today = Carbon::now()->toDateString();
            $todayOrders = Order::whereDate('created_at', $today)
                ->whereIn('load_type', ['box_truck_route', 'trailer_swap'])
                ->where('is_pick_tdf', false)
                ->with('fulfilled')->get();
            $totalWeightTillOrder = 0;
            $tdfAssignedOrder = [];
            // Need to get total Weight for 40K
            foreach ($todayOrders as $key => $todayOrder) {
                if ($todayOrder->load_type == 'box_truck_route' && !empty($todayOrder->fulfilled)) {
                    $lessThenWeight = abs((int) $request->start_weight) - ((int)$request->end_weight);
                    if ($totalWeightTillOrder >= $lessThenWeight) {
                        break;
                    }
                    $totalWeightTillOrder += $this->getTotalWeightOfOrder($todayOrder);
                    $todayOrder->load_value = $totalWeightTillOrder;

                    $tdfAssignedOrder[] = $todayOrder->id;
                    $todayOrder->is_pick_tdf = true;
                    $todayOrder->update();
                }
            }

            $fullFillOrder = TdfOrder::updateOrCreate(['order_id' => $request->order_id], $request->except(['customer_id', 'signed']));
            $fullFillOrder->recyle_order =  implode(',', $tdfAssignedOrder);
            $fullFillOrder->update();

            $order = Order::where('id', $request->order_id)->with(['customer', 'user'])->first();

            $order->status = 'fulfilled';
            $order->payment_type = $request->payment_type ?? null;

            $order->update();
            $fullFillOrder['order'] = $order;
            $fullFillOrder['tdf'] = $fullFillOrder;
            $customerPricing = CustomerPricing::where('customer_id', $order->customer_id)->first();
            $fullFillOrder['customerPricing'] = $customerPricing;

            $manifestPDF = new ManifestPDF();
            $manifestPDF->order_id = $request->order_id;
            $manifestPDF->customer_id = $order->customer_id;
            $test = null;
            $fullFillOrder['todaysOrder'] = $todayOrders;
            for ($i = 0; $i < count($pdfTypes); $i++) {
                $fullFillOrder['pdfType'] = $pdfTypes[$i];
                $pdf = \App::make('dompdf.wrapper');

                $customPaper = array(0, 0, 900, 1300);
                $pdf->setPaper($customPaper);
                $pdf->loadView('manifest.tdf', ['data' => $fullFillOrder]);

                $fullFillOrder['pdfType'] = $pdfTypes[$i];
                $output = $pdf->output();

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
            }
            $manifestPDF->save();

            return response()->json([
                'status' => true,
                'message' => 'TDF Order FullFilled Successfully',
                'manifest_link' => $manifestPDF->transporter
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function apiFulFillTrailerSwapOrder(Request $request)
    {

        try {
            //code...

            $pdfTypes = ['Generator', 'Transporter', 'Processor', 'Disposal', 'Original Generator'];
            $folderPath = 'signatures/';

            $image_parts = explode(";base64,", $request->signed);

            $image_type_aux = explode("image/", $image_parts[0]);

            if (!$image_type_aux[0] != '') {
                return response()->json([
                    'status' => false,
                    'message' => 'Signatures is required'
                ], 400);
            }


            $image_type = $image_type_aux[1];


            $image_base64 = base64_decode($image_parts[1]);

            $file = $folderPath . uniqid() . '.' . $image_type;
            file_put_contents($file, $image_base64);

            $request->merge([
                'cx_signature' => $file
            ]);

            //TODO: NEED TO FETCH TRAILERSWAP and BOXTRUCK ORDERS FOR CURRENT DAY.
            $fullFillOrder = TrailerSwapOrder::updateOrCreate(['order_id' => $request->order_id], $request->except(['customer_id', 'signed', 'payment_type', 'cheque_no', 'cash']));


            $order = Order::where('id', $request->order_id)->with(['customer', 'user'])->first();
            $customerPricing = CustomerPricing::where('customer_id', $order->customer_id)->first();

            $order->status = 'fulfilled';
            $order->payment_type = $request->payment_type ?? null;

            $order->update();
            $fullFillOrder['order'] = $order;
            $fullFillOrder['customerPricing'] = $customerPricing;

            $manifestPDF = new ManifestPDF();
            $manifestPDF->order_id = $request->order_id;
            $manifestPDF->customer_id = $order->customer_id;

            for ($i = 0; $i < count($pdfTypes); $i++) {
                $fullFillOrder['pdfType'] = $pdfTypes[$i];
                $pdf = \App::make('dompdf.wrapper');

                $customPaper = array(0, 0, 900, 1300);
                $pdf->setPaper($customPaper);
                $pdf->loadView('manifest.index', ['data' => $fullFillOrder]);

                $fullFillOrder['pdfType'] = $pdfTypes[$i];
                $output = $pdf->output();
                // return $pdf->stream();
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

            return response()->json([
                'status' => true,
                'message' => 'Trailer Swap Order FullFilled Successfully',
                'manifest_link' => $manifestPDF->transporter
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function apiFulFillOrder(Request $request)
    {
        try {
            
           
    // Log::critical($request->passanger_tyres_type);
    // return;

            $pdfTypes = ['Generator', 'Transporter', 'Processor', 'Disposal', 'Original Generator'];
            $folderPath = 'signatures/';

            $image_parts = explode(";base64,", $request->signed);
            $driverSign = explode(";base64,", $request->driver_signed);

            $image_type_aux = explode("image/", $image_parts[0]);
            $driver_sign_aux = explode("image/", $driverSign[0]);

            if (!$image_type_aux[0] != '') {
                return response()->json([
                    'status' => false,
                    'message' => 'Customer Signatures is required'
                ], 400);
            }
            if (!$driver_sign_aux[0] != '') {
                return response()->json([
                    'status' => false,
                    'message' => 'Driver Signatures is required'
                ], 400);
            };

            $image_type = $image_type_aux[1];
            $driver_image_type =  $driver_sign_aux[1];


            $image_base64 = base64_decode($image_parts[1]);
            $driver_base64 = base64_decode($driverSign[1]);

            $file = $folderPath . uniqid() . '.' . $image_type;
            file_put_contents($file, $image_base64);
            // DRIVER SIGN
            $driverSignFile = $folderPath . uniqid() . '.' . $driver_image_type;
            file_put_contents($driverSignFile, $driver_base64);

            //STORING TIRES TYPE IN JSON STRING

            $passangerTireTypes = explode(',',$request->passanger_tyres_type);
            $availablePassangerTireTypesArr = [];

            if (!empty($passangerTireTypes) && count($passangerTireTypes)) {
                foreach ($passangerTireTypes as $key => $value) {
                    $input =  $request[$value];
                    $values = explode(" ", $input);
                    $values = array_map('intval', $values);
                    $sum = array_sum($values);

                    $availablePassangerTireTypesArr[] = [
                        $value => $sum
                    ];
                }
            }


            //TRUCK TIRES TYPE

            $truckTireTypes = explode(',',$request->truck_tyres_type);
            $availableTruckTireTypesArr = [];

            if (!empty($truckTireTypes) && count($truckTireTypes)) {
                foreach ($truckTireTypes as $key => $value) {
                    $input =  $request[$value];
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
                    $input =  $request[$value];
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
                    $input =  $request[$value];
                    $values = explode(" ", $input);
                    $values = array_map('intval', $values);
                    $sum = array_sum($values);
                    $availableOtrTireTypesArr[] = [
                        $value => $sum
                    ];
                }
            }




            $fullFillOrder =  FullFillOrder::create([
                'type_of_passenger' => count($availablePassangerTireTypesArr) ? json_encode($availablePassangerTireTypesArr) : null,
                'type_of_agri_tyre' => count($availableAgriTireTypesArr) ? json_encode($availableAgriTireTypesArr) : null,
                'type_of_truck_tyre' => count($availableTruckTireTypesArr) ? json_encode($availableTruckTireTypesArr) : null,
                'type_of_other' => count($availableOtrTireTypesArr) ? json_encode($availableOtrTireTypesArr) : null,
                'order_id' => $request->order_id ?? null,
                'processor_reg_no' => $request->company_reg ?? null,
                'customer_signature' => $file ?? null,
                'driver_signature' => $driverSignFile ?? null,
                'cheque_no' => $request->cheque_no ?? null
            ]);


            $order = Order::where('id', $request->order_id)->with(['customer', 'user'])->first();
            $customerPricing = CustomerPricing::where('customer_id', $order->customer->id)->first();

            $order->status = 'fulfilled';
            $order->payment_type = $request->payment_type ?? null;

            $order->update();
            $fullFillOrder['order'] = $order;
            $fullFillOrder['customerPricing'] = $customerPricing;

            $manifestPDF = new ManifestPDF();
            $manifestPDF->order_id = $request->order_id;
            $manifestPDF->customer_id = $order->customer_id;

            for ($i = 0; $i < count($pdfTypes); $i++) {
                $fullFillOrder['pdfType'] = $pdfTypes[$i];
                $pdf = \App::make('dompdf.wrapper');

                $customPaper = array(0, 0, 900, 1500);
                $pdf->setPaper($customPaper);
                $pdf->loadView('manifest.index', ['data' => $fullFillOrder]);

                $fullFillOrder['pdfType'] = $pdfTypes[$i];
                $output = $pdf->output();
                $test = $pdf;
                // return $pdf->stream();
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

            return response()->json([
                'status' => true,
                'message' => 'Order FullFilled Successfully',
                'manifest_link' => $manifestPDF->transporter
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function apiFulFilSteelOrder(Request $request)
    {
        try {
            $folderPath = 'signatures/';
            $image_parts = explode(";base64,", $request->signed);

            $image_type_aux = explode("image/", $image_parts[0]);

            if (!$image_type_aux[0] != '') {
                return response()->json([
                    'status' => false,
                    'message' => 'Signatures is required'
                ], 400);
            }


            $image_type = $image_type_aux[1];


            $image_base64 = base64_decode($image_parts[1]);

            $file = $folderPath . uniqid() . '.' . $image_type;
            file_put_contents($file, $image_base64);

            $request->merge([
                'cx_signature' => $file
            ]);

            $fullFillOrder = SteelOrder::updateOrCreate(['order_id' => $request->order_id], $request->except(['customer_id', 'signed', 'address']));


            $order = Order::where('id', $request->order_id)->with(['customer', 'user'])->first();

            $order->status = 'compared';

            $order->update();

            return response()->json([
                'status' => true,
                'message' => 'Order FullFilled Successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function apiStateByWeight(Request $request){
        try {
            $pdfTypes = ['Generator', 'Transporter', 'Processor', 'Disposal', 'Original Generator'];
        // $pdfTypes = ['Generator'];
        $folderPath = 'signatures/';

        $image_parts = explode(";base64,", $request->signed);

        $image_type_aux = explode("image/", $image_parts[0]);

        if (!$image_type_aux[0] != '') {
            return response()->json([
                'status' => false,
                'message' => 'Signatures is required'
            ], 400);
        }


        $image_type = $image_type_aux[1];


        $image_base64 = base64_decode($image_parts[1]);

        $file = $folderPath . uniqid() . '.' . $image_type;
        file_put_contents($file, $image_base64);

        $request->merge([
            'cx_signature' => $file
        ]);

        $fullFillOrder = StateWeight::updateOrCreate(['order_id' => $request->order_id], $request->except(['customer_id', 'signed', 'address']));


        $order = Order::where('id', $request->order_id)->with(['customer', 'user'])->first();
        $customerPricing = CustomerPricing::where('customer_id', $order->customer_id)->first();

        $order->status = 'compared';

        $order->update();
        $fullFillOrder['order'] = $order;
        $fullFillOrder['orderType'] = 'stateWeight';
        $fullFillOrder['stateOrder'] = $fullFillOrder;
        $fullFillOrder['customerPricing'] = $customerPricing;
        $manifestPDF = new ManifestPDF();
        $manifestPDF->order_id = $request->order_id;
        $manifestPDF->customer_id = $order->customer_id;
        $testPDF = null;
        for ($i = 0; $i < count($pdfTypes); $i++) {
            $fullFillOrder['pdfType'] = $pdfTypes[$i];
            $pdf = \App::make('dompdf.wrapper');

            $customPaper = array(0, 0, 900, 1300);
            $pdf->setPaper($customPaper);
            $pdf->loadView('manifest.index', ['data' => $fullFillOrder]);

            $fullFillOrder['pdfType'] = $pdfTypes[$i];
            $output = $pdf->output();
            $testPDF = $pdf;
            // return $pdf->stream();
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

        return response()->json([
            'status' => true,
            'message' => 'Order FullFilled Successfully',
            'manifest_link' => $manifestPDF->transporter
        ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
