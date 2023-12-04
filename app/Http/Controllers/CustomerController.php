<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'business_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:customers'],
            'address' => ['required', 'string'],
            'phone_no' => ['required', 'string', 'min:8'],
            'poc_name' => ['required', 'string', 'max:255'],
         ]);
    
         Customer::create($request->all());
         return redirect('/register-customer')->with('success','Customer Created Successfully');   
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $customer = Customer::find($id);
        return view('customers.update', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {

$this->validate($request,[
    'business_name' => ['required', 'string', 'max:255'],
    'address' => ['required', 'string'],
    'phone_no' => ['required', 'string', 'min:8'],
    'poc_name' => ['required', 'string', 'max:255'],
 ]);
        $customer = Customer::find($id);
        $customer->update($request->all());

        return redirect()->back()->with('success', 'Customer Profile Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }

    public function searchCustomers(Request $request){
        if ($request->ajax()) {
            $data = Customer::where([
                ['business_name','LIKE',$request->name.'%'],
                ['status', 1]
            ])->with('notes')->get();
            $output = '';
            if (count($data)>0) {
                $output = '<ul class="list-group" style="display: block; position: relative; z-index: 1">';
                foreach ($data as $row) {
                    $notes =  count($row->notes) ? $row->notes[0]->note : "";
                    $output .= '<li class="list-group-item" data-lastest-note="' . $notes .'"  data-charge-type="'.$row->charge_type.'" data-mail-phone="' . $row->mail_phone . '" data-mail-address="' . $row->mail_address . '" data-second-mail="' . $row->second_mail . '" data-second-poc="' . $row->second_poc . '"  data-id="' . $row->id . '" data-email="' . $row->email . '" data-poc="' . $row->poc_name . '" data-address="' . $row->address . '" data-phone="' . $row->phone_no . '">' . $row->business_name . '</li>';
                }
                $output .= '</ul>';
            }else {
                $output .= '<li class="list-group-item">'.'No Data Found'.'</li>';
            }
            return $output;
        }
        // return view('autosearch');  
    }

    public function toggleCustomerStatus($id)
    {
        $customer = Customer::find($id);
        if ($customer) {
            $customer->status = $customer->status == 1 ? 0 : 1;
            $customer->update();
        }

        return redirect()->back()->with('success', 'CX Status Changed Successfully');
    }
}

