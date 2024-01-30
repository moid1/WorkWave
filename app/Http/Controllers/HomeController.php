<?php

namespace App\Http\Controllers;

use App\Models\AdminSettings;
use App\Models\Customer;
use App\Models\FullFillOrder;
use App\Models\Notes;
use App\Models\Order;
use App\Models\Truck;
use App\Models\TruckDriver;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $userType = Auth::user()->type;
        if ($userType == 0 || $userType == 1) {
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;

            $newCustomersCount = Customer::whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->count();
            $customersCountYTD = Customer::whereYear('created_at', $currentYear)
                ->whereDate('created_at', '<=', now())
                ->count();
            $boxTruckOrders = Order::where('load_type', 'box_truck_route')
                ->whereDate('created_at', now()->toDateString())
                ->with(['fulfilled'])
                ->get();
            $boxTruckOrdersWithDriver = $boxTruckOrders->whereNotNull('driver_id');
            $boxTruckOrdersWithoutDriver = $boxTruckOrders->whereNull('driver_id');
            $assignedTrucksNameArr = [];
            $assignedTrucksArr = [];
            $notAssignedTrucksArr = [];
            foreach ($boxTruckOrdersWithDriver as $order) {
                $assignedTruck = TruckDriver::where('user_id', $order->driver_id)->with('truck')->first();
                if ($assignedTruck && $assignedTruck->truck) {
                    $weight = $this->getTotalWeightOfOrder($order);
                    $assignedTrucksNameArr[] = [
                        'truckName'  => $assignedTruck->truck->name,
                        'is_overload' => $weight >=  16000 ? true : false
                    ];
                    $assignedTrucksArr[] = $assignedTruck->truck->id;
                }
            }
            $notAssignedTrucks = Truck::whereNotIn('id', $assignedTrucksArr)->get(['id', 'name']);
            $totalBoxOrderCompleted = $boxTruckOrders->where('status', 'compared')->count();
            $totalBoxOrderNotCompleted = $boxTruckOrders->where('status', 'created')->count();
            $dataArray = array();
            $dataArray['newCustomersCount'] = $newCustomersCount;
            $dataArray['customersCountYTD'] = $customersCountYTD;
            $dataArray['ordersCount'] = Order::all()->count();
            $dataArray['notesCount'] = Notes::all()->count();
            // Extract 'truckName' column
            $truckNames = array_column($assignedTrucksNameArr, 'truckName');

            // Get unique truck names
            $uniqueTruckNames = array_unique($truckNames);

            // Create a new array with unique truck names
            $uniqueAssignedTrucksNameArr = array_map(function ($truckName) use ($assignedTrucksNameArr) {
                $key = array_search($truckName, array_column($assignedTrucksNameArr, 'truckName'));
                return $assignedTrucksNameArr[$key];
            }, $uniqueTruckNames);

            $assignedTrucksNameArr = $uniqueAssignedTrucksNameArr;

            $dataArray['boxTruckassignedTrucks'] = $assignedTrucksNameArr;
            $dataArray['boxNotAssignedTrucks'] = $notAssignedTrucks;
            $dataArray['totalBoxOrderCompleted'] = $totalBoxOrderCompleted;
            $dataArray['totalBoxOrderNotCompleted'] = $totalBoxOrderNotCompleted;
            $dataArray['totalTiresCollectedToday'] = $this->getTotalTiresCollectionToday();
            $dataArray['totalTiresCollectedYTD'] = $this->getTotalTiresCollectionYTD();
            $dataArray['boxTruckMissedCX'] = $this->getCXMissedBoxTruck();
            $dataArray['boxTruckCompletedJobs'] = $this->getBoxTruckTotalCompletedJobs();
            $adminSettings = AdminSettings::first();
            $tdfData = $this->tdfData();
            $steelData = $this->steelData();
            $materialShippedData = $this->getMaterialShippedDataMonthly();
            $materialShippedYearly = $this->getMaterialShippedDataYearly();
            return view('home', compact('dataArray', 'adminSettings', 'tdfData', 'steelData', 'materialShippedData', 'materialShippedYearly'));
        } else if ($userType == 2) {
            $orders = Order::where('driver_id', Auth::user()->id)->get();
            return view('driver.home', compact('orders'));
        } else if ($userType == 3) {
            $customerId = Customer::where('user_id', Auth::id())->first()->only('id');
            $orders = Order::where('customer_id', $customerId['id'])->with(['manifest'])->get();
            return view('customers.home', compact('orders'));
        }
    }

    public function changePassword()
    {
        return view('change-password');
    }

    public function updatePassword(Request $request)
    {
        # Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);


        #Match The Old Password
        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return back()->with("error", "Old Password Doesn't match!");
        }


        #Update the new Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with("status", "Password changed successfully!");
    }

    public function getManifest()
    {
        $pdf = \App::make('dompdf.wrapper');

        $customPaper = array(0, 0, 900, 1200);
        $pdf->setPaper($customPaper);
        $pdf->loadView('manifest.index');
        return $pdf->stream();
        // $pdfPath = public_path().'/manifest/pdfs/'.time().'.pdf';
        // file_put_contents($pdfPath, $output);
        return view('manifest.index');
    }

    public function getDashboardStats()
    {
        try {
            $userType = Auth::user()->type;
            if ($userType == 0 || $userType == 1) {
                $customers = Customer::latest()->take(5)->get();
                $dataArray = array();
                $dataArray['customersCount'] = Customer::all()->count();
                $dataArray['ordersCount'] = Order::all()->count();
                $dataArray['notesCount'] = Notes::all()->count();
                return response()->json([
                    'status' => true,
                    'message' => 'Data retrived successfully',
                    'data' => [
                        'customers' => $customers,
                        'stats' => $dataArray
                    ],
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getTotalTiresCollectionToday()
    {
        //getting data for tires today

        $boxTruckFullFilledOrders =  FullFillOrder::whereDate('created_at', now()->toDateString())->get();
        $totalTiresSum = 0;
        foreach ($boxTruckFullFilledOrders as $key => $fulfillorder) {
            if (!empty($fulfillorder->type_of_passenger)) {
                $type_of_passenger = json_decode($fulfillorder->type_of_passenger, true);
                foreach ($type_of_passenger as $item) {
                    foreach ($item as $key => $value) {
                        $totalTiresSum += (int) $value;
                    }
                }
            }

            if (!empty($fulfillorder->type_of_agri_tyre)) {
                $type_of_agri_tyre = json_decode($fulfillorder->type_of_agri_tyre, true);
                foreach ($type_of_agri_tyre as $item) {
                    foreach ($item as $key => $value) {
                        $totalTiresSum += (int) $value;
                    }
                }
            }

            if (!empty($fulfillorder->type_of_truck_tyre)) {
                $type_of_truck_tyre = json_decode($fulfillorder->type_of_truck_tyre, true);
                foreach ($type_of_truck_tyre as $item) {
                    foreach ($item as $key => $value) {
                        $totalTiresSum += (int) $value;
                    }
                }
            }

            if (!empty($fulfillorder->type_of_other)) {
                $type_of_other = json_decode($fulfillorder->type_of_other, true);
                foreach ($type_of_other as $item) {
                    foreach ($item as $key => $value) {
                        $totalTiresSum += (int) $value;
                    }
                }
            }
        }

        return $totalTiresSum;
    }

    public function getTotalTiresCollectionYTD()
    {
        $currentYear = Carbon::now()->year;
        $fulfillorderYTD = FullFillOrder::whereYear('created_at', $currentYear)
            ->whereDate('created_at', '<=', now())
            ->get();

        $totalTiresYTD = 0;
        foreach ($fulfillorderYTD as $key => $fulfillorder) {
            if (!empty($fulfillorder->type_of_passenger)) {
                $type_of_passenger = json_decode($fulfillorder->type_of_passenger, true);
                foreach ($type_of_passenger as $item) {
                    foreach ($item as $key => $value) {
                        $totalTiresYTD += (int) $value;
                    }
                }
            }

            if (!empty($fulfillorder->type_of_agri_tyre)) {
                $type_of_agri_tyre = json_decode($fulfillorder->type_of_agri_tyre, true);
                foreach ($type_of_agri_tyre as $item) {
                    foreach ($item as $key => $value) {
                        $totalTiresYTD += (int) $value;
                    }
                }
            }

            if (!empty($fulfillorder->type_of_truck_tyre)) {
                $type_of_truck_tyre = json_decode($fulfillorder->type_of_truck_tyre, true);
                foreach ($type_of_truck_tyre as $item) {
                    foreach ($item as $key => $value) {
                        $totalTiresYTD += (int) $value;
                    }
                }
            }

            if (!empty($fulfillorder->type_of_other)) {
                $type_of_other = json_decode($fulfillorder->type_of_other, true);
                foreach ($type_of_other as $item) {
                    foreach ($item as $key => $value) {
                        $totalTiresYTD += (int) $value;
                    }
                }
            }
        }

        return $totalTiresYTD;
    }

    public function getCXMissedBoxTruck()
    {
        $orders = Order::where([['load_type', 'box_truck_route'], ['status', 'created']])->whereDate('created_at', '<=', now())->with('customer')->get();
        return $orders;
    }

    public function getBoxTruckTotalCompletedJobs()
    {

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $totalJobsCompletedByMonth = Order::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)->where('status', 'compared')
            ->count();

        $totalJobsCompletedByYear = Order::whereYear('created_at', $currentYear)->where('status', 'compared')
            ->count();

        return [$totalJobsCompletedByMonth, $totalJobsCompletedByYear];
    }


    public function generateDailyCountSheet(Request $request)
    {
        $NotIncluded = ['steel', 'tdf'];

        if ($request->date) {
            $todaysOrders = Order::whereDate('created_at', $request->date)->whereNotIn('load_type', $NotIncluded)
                ->whereNotNull('driver_id')
                ->with(['driver', 'customer', 'fulfilled', 'compared'])
                ->get()
                ->groupBy('driver_id')
                ->map
                ->flatten()
                ->toArray();;
        } else {
            $todaysOrders = Order::whereDate('created_at', now()->toDateString())
                ->whereNotIn('load_type', $NotIncluded)
                ->whereNotNull('driver_id')
                ->with(['driver', 'customer', 'fulfilled', 'compared'])
                ->get()
                ->groupBy('driver_id')
                ->map
                ->flatten()
                ->toArray();
        }
        // dd($todaysOrders);
        return view('countsheet.daily', compact('todaysOrders'));
    }

    public function tdfData()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $todaysOrders = Order::whereDate('created_at', now()->toDateString())->where([['load_type', 'tdf']])->with('tdfOrder')->get();
        $ordersOfCurrentMonth =  Order::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)->where([['load_type', 'tdf']])->with('tdfOrder')->get();
        $totalLoadsToday = 0;
        $totalTonsDelivered = 0;
        $totalTonNeeded = 0;
        foreach ($todaysOrders as $key => $order) {
            if ($order->tdfOrder) {
                $totalLoadsToday++;
                $totalTonsDelivered += ($order->tdfOrder->end_weight - $order->tdfOrder->start_weight) / 2000;
            }
        }

        foreach ($ordersOfCurrentMonth as $key => $order) {
            if ($order->tdfOrder) {
                $totalTonNeeded += ($order->tdfOrder->end_weight - $order->tdfOrder->start_weight) / 2000;
            }
        }
        $adminSettings = AdminSettings::first();
        if ($adminSettings) {
            $totalTonNeeded = number_format((($totalTonNeeded / (($adminSettings->total_tons_need) / 12))), 2);
        }


        // Get the current date
        $currentDate = Carbon::now();
        $firstDayOfMonth = $currentDate->copy()->startOfMonth();
        $lastDayOfMonth = $currentDate->copy()->endOfMonth();
        $daysCount = 0;
        // Loop from the first day of the month until the current date
        while ($firstDayOfMonth->lte($lastDayOfMonth)) {
            // Check if the current day is from Monday to Saturday
            if ($firstDayOfMonth->dayOfWeek >= Carbon::MONDAY && $firstDayOfMonth->dayOfWeek <= Carbon::SATURDAY) {
                $daysCount++;
            }
            // Move to the next day
            $firstDayOfMonth->addDay();
        }
        $todaysCompletion = number_format(($adminSettings->total_tons_need / 12) / $daysCount, 2);
        return array('totalLoadsToday' => $totalLoadsToday, 'totalTonsDelivered' => $totalTonsDelivered, 'totalTonNeeded' => $totalTonNeeded, 'todaysCompletion' => $todaysCompletion);
    }

    public function steelData()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $todaysOrders = Order::whereDate('created_at', now()->toDateString())->where([['load_type', 'steel']])->with('steel')->get();
        $ordersOfCurrentMonth =  Order::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)->where([['load_type', 'steel']])->with('steel')->get();
        $totalLoadsToday = 0;
        $totalTonsDelivered = 0;
        $totalTonNeeded = 0;
        foreach ($todaysOrders as $key => $order) {
            if ($order->steel) {
                $totalLoadsToday++;
                $totalTonsDelivered += ($order->steel->end_weight - $order->steel->start_weight) / 2240;
            }
        }

        foreach ($ordersOfCurrentMonth as $key => $order) {
            if ($order->steel) {
                $totalTonNeeded += ($order->steel->end_weight - $order->steel->start_weight) / 2240;
            }
        }
        $adminSettings = AdminSettings::first();
        if ($adminSettings) {
            $totalTonNeeded = number_format((($totalTonNeeded / (($adminSettings->total_tons_need) / 12))), 2);
        }


        // Get the current date
        $currentDate = Carbon::now();
        $firstDayOfMonth = $currentDate->copy()->startOfMonth();
        $lastDayOfMonth = $currentDate->copy()->endOfMonth();
        $daysCount = 0;
        // Loop from the first day of the month until the current date
        while ($firstDayOfMonth->lte($lastDayOfMonth)) {
            // Check if the current day is from Monday to Saturday
            if ($firstDayOfMonth->dayOfWeek >= Carbon::MONDAY && $firstDayOfMonth->dayOfWeek <= Carbon::SATURDAY) {
                $daysCount++;
            }
            // Move to the next day
            $firstDayOfMonth->addDay();
        }
        $todaysCompletion = number_format(($adminSettings->total_tons_need / 12) / $daysCount, 2);
        return array('totalLoadsToday' => $totalLoadsToday, 'totalTonsDelivered' => $totalTonsDelivered, 'totalTonNeeded' => $totalTonNeeded, 'todaysCompletion' => $todaysCompletion);
    }

    public function getMaterialShippedDataMonthly()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $materialOrders = ['tdf', 'steel'];
        $ordersOfCurrentMonth =  Order::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)->whereIn('load_type', $materialOrders)->with(['steel', 'tdfOrder'])->get();

        $totalTonsDeliverdMonthly = 0;
        foreach ($ordersOfCurrentMonth as $key => $order) {
            if ($order->tdfOrder) {
                $totalTonsDeliverdMonthly += ($order->tdfOrder->end_weight - $order->tdfOrder->start_weight) / 2000;
            } else if ($order->steel) {
                $totalTonsDeliverdMonthly += ($order->steel->end_weight - $order->steel->start_weight) / 2240;
            }
        }
        return array('totalTonsDelivered' => $totalTonsDeliverdMonthly);
    }

    public function getMaterialShippedDataYearly()
    {
        $currentYear = Carbon::now()->year;
        $materialOrders = ['tdf', 'steel'];
        $ordersOfCurrentYear =  Order::whereYear('created_at', $currentYear)->whereIn('load_type', $materialOrders)->with(['steel', 'tdfOrder'])->get();

        $totalTonsDeliverd = 1;
        foreach ($ordersOfCurrentYear as $key => $order) {
            if ($order->tdfOrder) {
                $totalTonsDeliverd += ($order->tdfOrder->end_weight - $order->tdfOrder->start_weight) / 2000;
            } else if ($order->steel) {
                $totalTonsDeliverd += ($order->steel->end_weight - $order->steel->start_weight) / 2240;
            }
        }
        return array('totalLoads' => $ordersOfCurrentYear->count(), 'totalTonsDelivered' => $totalTonsDeliverd);
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
}
