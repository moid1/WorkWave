<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Notes;
use App\Models\Order;
use App\Models\User;
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
            $customers = Customer::latest()->take(5)->get();
            $dataArray = array();
            $dataArray['customersCount'] = Customer::all()->count();
            $dataArray['ordersCount'] = Order::all()->count();
            $dataArray['notesCount'] = Notes::all()->count();
            return view('home', compact('customers', 'dataArray'));
        } else if ($userType == 2) {
            $orders = Order::where('driver_id', Auth::user()->id)->get();
            return view('driver.home', compact('orders'));
        }else if($userType == 3){
            $orders = Order::where('customer_id', Auth::user()->id)->get();
            dd($orders);
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

    public function getManifest(){
        $pdf = \App::make('dompdf.wrapper');

        $customPaper = array(0,0,900,1200);
        $pdf->setPaper($customPaper);
        $pdf->loadView('manifest.index');
       return $pdf->stream();
        // $pdfPath = public_path().'/manifest/pdfs/'.time().'.pdf';
        // file_put_contents($pdfPath, $output);
        return view('manifest.index');
    }
}
