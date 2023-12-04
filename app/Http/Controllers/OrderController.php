<?php

namespace App\Http\Controllers;

use App\Models\Notes;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{

    protected $WORKWAVE_URL = 'https://wwrm.workwave.com/api/v1/territories/9c7ab89c-81d3-4d0a-9cd8-61390a286ad8/orders';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with(['customer', 'user'])->get();
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $drivers = User::where('type', 2)->get();   
        return view('orders.create', compact('drivers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'driver_id' => ['required']
         ]);
    
        $date = null;

        if($request->date){
            $date =   str_replace("-", "", $request->date);
        }
       $loads =  null;
       if( $request->load_type === 'swap'){
        $loads = array(
            'swap' =>100
        );
       }else{
        $loads = array(
            'box' => ((int)$request['box_amount'])*100
        );
       }

        $timeWindows =  array('startSec' => 28800, 'endSec' => 18000);
        $eligibility = $request->date ? array(
            "type" => "on",
            "onDates" =>  [$date]
        ):null;

        $payload = [
            "strict" => false,
            "acceptBadGeocodes" => true,
            'orders' => [
                array(
                    'name' => $request['business_name'],
                    'eligibility' =>$eligibility,
                    'pickup' => array(
                        'location' => array(
                            'address' => $request['address'],
                        ),
                        'notes' => $request['notes'] ?? '',
                        'email' => $request['email'],
                        'phone' => $request['phone_no'],
                        'serviceTimeSec' => $request->serviceTime ?? 1800,
                        'customFields' => array(
                            'poc' => $request->poc_name,
                            'cx_phone' => $request['phone_no']
                        ),
                    ),
                    'loads' => $loads,
                    'requiredTruck' => 'none',
                )
            ]
        ];

        if ($request->load_type === 'swap') {
            $payload['orders'][0]['delivery'] = array(
                'location' => array(
                    'address' => '3345 E State Highway 29 Burnet, TX 78611',
                ),
                'phone' => $request['phone_no'],
                'email' => $request['email'],
                'serviceTimeSec' => (int)$request->serviceTime ?? 1800,
                'notes' => $request['notes'] ?? '',
                'customFields' => array(
                    'poc' => $request->poc_name,
                    'cx_phone' => $request['phone_no']
                ),
            );
        }

        $order = Order::create([
            'customer_id'=>$request['customer_id'],
            'user_id'=> Auth::id(),
            'notes' => $request['notes'] ?? 'N/A',
            'load_type' => (int)$request['load_type'],
            'load_value' => $request->load_type === 'swap'? $request['swap_amount'] :  $request['box_amount'],
            'driver_id' => $request['driver_id']

        ]);

        $notes = Notes::create([
            'customer_id'=>$request['customer_id'],
            'user_id'=> Auth::id(),
            'note' => $request['notes'] ?? 'N/A',
            'title' => 'Order Note'
        ]);
    //   $response =   $this->callWorkWave($payload);
    //   $order->api_response = json_encode($response);
    //   $order->update();
      return redirect('/orders')->with('success','Order Created Successfully');   

    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    public function callWorkWave($data){

        $response = Http::withHeaders([
            'X-WorkWave-Key' => '476563b3-8bc4-4493-81e6-4098be89dbbc',
        ])->post($this->WORKWAVE_URL,$data, $data);

        return($response->json());

    }

    public function driverOrders(){
       $orders = Order::where('driver_id', Auth::id())->with(['customer', 'user'])->latest()->get();
       return view('orders.driver.index', compact('orders'));
    }
}
