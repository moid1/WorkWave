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
                ->get();
            $boxTruckOrdersWithDriver = $boxTruckOrders->whereNotNull('driver_id');
            $boxTruckOrdersWithoutDriver = $boxTruckOrders->whereNull('driver_id');
            $assignedTrucksNameArr = [];
            $assignedTrucksArr = [];
            $notAssignedTrucksArr = [];
            foreach ($boxTruckOrdersWithDriver as $order) {
                $assignedTruck = TruckDriver::where('user_id', $order->driver_id)->with('truck')->first();
                if ($assignedTruck) {
                    $assignedTrucksNameArr[] = $assignedTruck->truck->name;
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
            $assignedTrucksNameArr = array_unique($assignedTrucksNameArr);

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


    public function generateDailyCountSheet()
    {
        $todaysOrders = Order::whereDate('created_at', now()->toDateString())
            ->whereNotNull('driver_id')
            ->with(['driver', 'customer', 'fulfilled'])
            ->get()
            ->groupBy('driver_id')
            ->map
            ->flatten()
            ->toArray();
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

        $totalTonsDeliverd = 0;
        foreach ($ordersOfCurrentYear as $key => $order) {
            if ($order->tdfOrder) {
                $totalTonsDeliverd += ($order->tdfOrder->end_weight - $order->tdfOrder->start_weight) / 2000;
            } else if ($order->steel) {
                $totalTonsDeliverd += ($order->steel->end_weight - $order->steel->start_weight) / 2240;
            }
        }
        return array('totalLoads' => $ordersOfCurrentYear->count(), 'totalTonsDelivered' => $totalTonsDeliverd);
    }
}
