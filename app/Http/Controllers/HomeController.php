<?php

namespace App\Http\Controllers;

use App\Models\Customer;
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
            $dataArray['boxTruckassignedTrucks'] = $assignedTrucksNameArr;
            $dataArray['boxNotAssignedTrucks'] = $notAssignedTrucks;
            $dataArray['totalBoxOrderCompleted'] = $totalBoxOrderCompleted;
            $dataArray['totalBoxOrderNotCompleted'] = $totalBoxOrderNotCompleted;

            return view('home', compact('dataArray'));
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
}
