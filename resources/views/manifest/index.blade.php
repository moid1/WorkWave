<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Page Title</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <style>
      @import url("https://fonts.googleapis.com/css2?family=Inter:wght@100;300;400;600;700;900&family=Roboto+Condensed:ital,wght@0,100;0,300;0,400;0,600;0,700;0,900;1,100;1,300;1,400;1,600;1,700;1,900&display=swap");
*{
  margin: 0;
  padding: 0;
}
      body {
        font-family: "Inter", Arial, sans-serif;
      
      }
      #page-bg {
      position: fixed;
      inset: -1in;
      background-color:white;
      z-index: -1000;
    }
      .inputLabel {
        font-size: 0.88rem;
        font-weight: bold;
        text-transform: capitalize;
      }

      .inputLabelExtraSmall {
        margin-top: 10px;
        min-width: 35px;

      }

      .inputLabelSmall {
        margin-top: 10px;
        min-width: 55px;
      }

      .inputField {
        height: 30px;
        border: none;
        border-bottom: 1px solid #333;
        width: 90%;
        background: none;
        font-weight: 600;
      }

      .inputField-2 {
        height: 30px;
        border: none;
        border-bottom: 1px solid #333;
        width: 60%;
        background: none;
        font-weight: 600;
      }

      .inputField:focus-visible {
        outline: none;
        border-bottom: 2px solid #333;
      }

    </style>
  </head>

  <body >
    <div id="page-bg"></div>

    <table class="table table-borderless" >
      <tbody>
          <tr>
            <td style="width: 50%">
                <div class="table-responsive">
                  <table class="table table-borderless table-sm" >
                    <tbody>
                      <tr>
                        <!-- Reliable Tire Disposal -->
                        <div class="container col-12 col-md-6">
                          <div>
                            <h2 class="text-center text-uppercase fw-bold">
                              reliable tire disposal
                            </h2>
                            <h4 class="text-center text-uppercase fw-bold">
                             132 CR 305<br />burnet, tx 78611<br />(512) 756-8218
                            </h4>
                          </div>
                        </div>
                      </tr>

                      <tr>
                        <div class="row">
                          <h6 class="fw-bold text-uppercase mt-3" style="white-space: nowrap">
                            1. generator information and certification:
                          </h6>
                        </div>
                      </tr>

                      <tr>
                        <div class="d-flex flex-column">
                          @php
                           $currentTime = now();   
                          @endphp
                          <span class="inputField" style="display: inline-block;">{{$currentTime}}</span>
                          <label class="inputLabel">Date and Time of Pickup</label>
                        </div>
                      </tr>

                      <tr>
                        <div class="d-flex flex-column">
                          <span class="inputField" style="display: inline-block;"></span>
                          <label class="inputLabel"
                            >Registration Number/Type of Generator</label
                          >
                        </div>
                      </tr>
                      <tr>
                        <td>
                          <div style="display: inline-block" >
                            <input type="text" name="" value="" class="inputField" />
                            <label class="inputLabel" style="white-space: nowrap">Area Code</label>
                          </div>

                          <div style="display: inline-flex;margin-top:10px">
                            <input type="text" name="" value="{{$data->order->customer->phone_no}}" class="inputField" />
                            <label class="inputLabel">Telephone Number</label>
                          </div>
                        </td>
                      </tr>

                      <tr>
                        <div class="d-flex flex-column">
                          <input type="text" name="" value="{{$data->order->customer->business_name}}" class="inputField" />
                          <label class="inputLabel"
                            >Company Name</label
                          >
                        </div>
                      </tr>
                      <!-- Street Address -->
                    
                    <tr>
                      <div class="d-flex flex-column">
                        <input type="text" name="" value="{{$data->order->customer->address}}" class="inputField" />
                        <label class="inputLabel">Street Address</label>
                      </div>
                    </tr>

                    <tr >
                      <td style="justify-content:left">
                        <div style="display: inline-flex;width:200px;" >
                          <span style="display: inline-block;height:20px" class="inputField">Fort Worth</span>
                          <label class="inputLabel" style="white-space: nowrap">City</label>
                        </div>

                        <div style="display: inline-flex;margin-left:-20px">
                          <span style="display: inline-block" class="inputField">TX</span>
                          <label class="inputLabel">State</label>
                        </div>
                        <div style="display: inline-flex">
                          <span style="display: inline-block" class="inputField">76120</span>
                          <label class="inputLabel">Zip</label>
                        </div>
                      </td>
                    </tr>

                    <tr>
                      <div >
                        <label 
                          class="inputLabel"
                          style="margin-top: 10px;width:140px "
                          >No. Passenger tires</label>
                          <span style="display:inline-block;background:none;border:none;border-bottom: 1px solid #333;width:120px">{{$data->no_of_passenger}}</span>
                       

                        <label class="inputLabel inputLabelExtraSmall" style="width: 25px;"
                        >@ $</label>
                        <span style="display:inline-block;background:none;border:none;border-bottom: 1px solid #333;width:50px">{{$data->order->customer->passenger_pricing}}</span>

                        <label class="inputLabel inputLabelSmall"
                        >Total $</label>
                        @php
                        $total_passenger_pricing = 0;
                        if($data->no_of_passenger){
                          $total_passenger_pricing = floatval($data->no_of_passenger) * floatval($data->order->customer->passenger_pricing) ;
                        }
                        @endphp
                        <span style="display:inline-block;background:none;border:none;border-bottom: 1px solid #333;width:50px">{{$total_passenger_pricing}}</span>
                      </div>
                  </tr>
                  <tr>
                    <div class="mt-2">
                      <label 
                        class="inputLabel"
                        style="margin-top: 10px;width:140px; "
                        >No. Truck tires</label>
                        <span style="display:inline-block;background:none;border:none;border-bottom: 1px solid #333;width:120px">{{$data->no_of_truck_tyre}}</span>

                      <label class="inputLabel inputLabelExtraSmall" style="width: 25px;"
                      >@ $</label>
                      <span style="display:inline-block;background:none;border:none;border-bottom: 1px solid #333;width:50px">{{$data->order->customer->truck_pricing}}</span>

                      <label class="inputLabel inputLabelSmall"
                      >Total $</label>
                      <span style="display:inline-block;background:none;border:none;border-bottom: 1px solid #333;width:50px">{{$data->order->customer->truck_pricing * $data->no_of_truck_tyre}}</span>

                    </div>
                  </tr>

                  <tr>
                    <div class="mt-2">
                      <label 
                        class="inputLabel"
                        style="margin-top: 10px; width:140px; "
                        >No. Agri tires</label
                      >

                      <span style="display:inline-block;background:none;border:none;border-bottom: 1px solid #333;width:120px">{{$data->no_of_agri_tyre}}</span>


                      <label class="inputLabel inputLabelExtraSmall" style="width: 25px;"
                      >@ $</label>
                      <span style="display:inline-block;background:none;border:none;border-bottom: 1px solid #333;width:50px">{{$data->order->customer->agri_pricing}}</span>

                    

                      <label class="inputLabel inputLabelSmall"
                      >Total $</label>
                      <span style="display:inline-block;background:none;border:none;border-bottom: 1px solid #333;width:50px">{{$data->order->customer->agri_pricing * $data->no_of_agri_tyre}}</span>
                    </div>
                  </tr>

                  <tr>
                    <div class="mt-2">
                      <label 
                        class="inputLabel"
                        style="margin-top: 10px;width:140px; "
                        >No. Other tires</label
                      >

                      <span style="display:inline-block;background:none;border:none;border-bottom: 1px solid #333;width:120px">{{$data->no_of_other}}</span>

                      <label class="inputLabel inputLabelExtraSmall"
                      >@ $</label>
                      <span style="display:inline-block;background:none;border:none;border-bottom: 1px solid #333;width:50px">{{$data->order->customer->other}}</span>
                    

                      <label class="inputLabel inputLabelSmall"
                      >Total $</label>
                      <span style="display:inline-block;background:none;border:none;border-bottom: 1px solid #333;width:50px">{{$data->order->customer->other * $data->no_of_other}}</span>

                    </div>
                </tr>
                <tr style="text-align: right;">
                  <!-- Total $ - 1 -->
                  <div class="mt-2 "  >
                    <label class="inputLabel inputLabelSmall"
                      >Total $</label>
                      @php
                      $totalWithoutTax = $data->order->customer->other * $data->no_of_other + $data->order->customer->agri_pricing * $data->no_of_agri_tyre + $data->order->customer->truck_pricing * $data->no_of_truck_tyre;
                      @endphp
                    <input
                      type="text"
                      name=""
                      value="{{($totalWithoutTax)}}"
                      style="background:none;border:none;border-bottom: 1px solid #333;max-width:55px;margin-right:5em;"
                      />
                  </div>
                </tr>


               <tr style="text-align: right;">
                <div class="mt-2 " >
                  <label class="inputLabel" style="margin-top: 10px; min-width: 85px">Sales Tax $</label>
                  <input
                  type="text"
                  name=""
                  value="{{$data->order->customer->tax ?? 0}}%"
                  style="background:none;border:none;border-bottom: 1px solid #333;max-width:55px;margin-right:5em;"
                  />
                </div>
              </tr>

              <tr style="text-align: right;">
                <div class="mt-2 " >
                  <label class="inputLabel inputLabelSmall">Total $</label>
                  <input
                  type="text"
                  name=""
                  value="{{($totalWithoutTax*$data->order->customer->tax)+($totalWithoutTax)}}"
                  style="background:none;border:none;border-bottom: 1px solid #333;max-width:55px;margin-right:5em;"
                  />
                </div>
              </tr>
                          </tbody>
                      </table>
                  </div> 
              </td>
              <td style="width: 50%; padding:0%;">
                  <div class="table-responsive" >
                      <table class="table table-borderless table-sm">
                          <tbody>
                              <tr>
                                <div class="col-12 col-md-6">
                                  <div>
                                    <div class="d-flex felx-row gap-3">
                                      <h3 class="text-center text-capiatlize fw-bold">
                                        Whole Used or Scrap Tire Manifest <span style="color: red">000{{$data->order->id}}</span>
                                      </h3>
                                    </div>
                                    <p
                                    class=" text-uppercase text-center "
                                    style="font-size: 0.88rem; line-height: normal"
                                  >
                                  texas natural resource conservation commission
                                  <br>
                                  P.O. Box 13087<span class="mx-1">&#x2022;</span>Austin, Texas
                                  78711-3087<span class="mx-1">&#x2022;</span>512-239-6001
                                  </p>
                                  </div>
                                </div>
                              </tr>
<br>
                              <tr>
                                <div class="row">
                                  <h6 class="fw-bold text-uppercase mt-3" style="white-space: nowrap">
                                    2. transporter information and certification:
                                  </h6>
                                </div>
                              </tr>

                              <tr>
                                <div class="d-flex flex-column">
                                  <input type="text" name="" value="RELIABLE TIRE DISPOSAL" class="inputField" />
                                  <label class="inputLabel">Company Name</label>
                                </div>
                              </tr>

                              <tr class="">
                                                    <!-- registration number - driver's license number -->
                                                   
                                                      <div style="margin-top:15px;display: inline-flex;min-width:350px;" >
                                                        <input
                                      type="text"
                                      name=""
                                      value="6200792 "
                                      class="inputField"
                                    />
                                    <label class="inputLabel">registration number</label>
                                  </div>


                                  <div style="display: inline-flex;min-width:100px;" >
                                    <input
                                      type="text"
                                      name=""
                                      value="{{Auth::user()->driver_license ?? 'N/A'}}"
                                      class="inputField"
                                    />
                                    <label class="inputLabel">Driver's License Number</label>
                                  </div>

                              </tr>

                              <tr>
                                <div class="">
                                  <input type="text" name="" value="{{Auth::user()->name ?? 'N/A'}}" class="inputField" />
                                  <label class="inputLabel">Print Name</label>
                                </div>
                              </tr>

                              <tr>
                                <div class="">
                                  <input type="text" name="" value="" class="inputField" />
                                  <label class="inputLabel">Signature</label>
                                </div>
                              </tr>

                              <tr>
                                <div class="row">
                                  <h6 class="fw-bold text-uppercase mt-3" style="white-space: nowrap">
                                    3. secondary transporter information and certification
                                  </h6>
                                </div>
                              </tr>

                              <tr>
                                <div class="d-flex flex-column">
                                  <input type="text" name="" value="" class="inputField" />
                                  <label class="inputLabel">Company Name</label>
                                </div>
                              </tr>

                              <tr class="" style="background: red">
                                                    <!-- registration number - driver's license number -->
                                                   
                                                      <div style="display: inline-flex;min-width:350px;" >
                                                        <input
                                      type="text"
                                      name=""
                                      value=""
                                      class="inputField"
                                    />
                                    <label class="inputLabel">registration number</label>
                                  </div>


                                  <div style="display: inline-flex;min-width:100px;" >
                                    <input
                                      type="text"
                                      name=""
                                      value=""
                                      class="inputField"
                                    />
                                    <label class="inputLabel">Driver's License Number</label>
                                  </div>

                              </tr>

                              <tr>
                                <div class="">
                                  <input type="text" name="" value="" class="inputField" />
                                  <label class="inputLabel">Print Name</label>
                                </div>
                              </tr>

                              <tr>
                                <div class="">
                                  <input type="text" name="" value="" class="inputField" />
                                  <label class="inputLabel">Signature</label>
                                </div>
                              </tr>
<br>
<tr>
                                <span
                                class="fw-bold "
                                style="font-size: 0.88rem; line-height: normal;margin-top:5px"
                                >I certify that the information provided above is true and
                                correct. I am aware that falsification of this manifest may
                                result in suspension, revocation, or denial of renewal of my
                                generator/transporter registration.</span>
                
                              </tr>

                              <tr>
                                <div class="">
                                  <input type="text" name="" value="" class="inputField" />
                                  <label class="inputLabel">Print Name</label>
                                </div>
                              </tr>

                              <tr>
                                <div class="">
                                  <input type="text" name="" value="" class="inputField" />
                                  <label class="inputLabel">Signature</label>
                                </div>
                              </tr>
                             
                          </tbody>
                      </table>

                      
                  </div>
              </td>
          </tr>
      </tbody>
  </table>
 <!-- adjustment box -->

 <div class=" p-3" style="background: #979d9d65;border:4px solid black">
    <div >
      <h6  class="text-uppercase fw-bold"  style="float: left;width:65%">adjustment box</h6>
      <p   class=" fw-bold " style="justify-content: right">Location and Intended Use of Removed tires:</p>
    </div>

<table style="width: 100%">
  <tbody>
    <tr >
    
      <div >
        <label class="inputLabel" style="margin-top: 10px; min-width: 160px;"
        >No. of Tires Picked Up:</label
      >
          <input style="border-bottom: 1px solid #333;min-width:150px"
          type="number" name="" value=""  />
          <label  class="inputLabel">passenger tires</label>

          <input style="border-bottom: 1px solid #333;min-width:150px"
          type="number" name="" value=""  />
          <label class="inputLabel">Truck tires</label>
          
      </div>
     
  </tr>

  <tr >
    
    <div >
      <label class="inputLabel" style="margin-top: 10px; min-width: 160px;"
      >removed for reuse:</label
    >
        <input style="border-bottom: 1px solid #333;min-width:150px"
        type="number" name="" value=""  />
        <label  class="inputLabel">passenger tires</label>

        <input style="border-bottom: 1px solid #333;min-width:150px"
        type="number" name="" value=""  />
        <label class="inputLabel">Truck tires</label>
        
    </div>
   
</tr>

<tr >
    
  <div >
    <label class="inputLabel" style="margin-top: 10px; min-width: 160px;"
    >to be delivered:</label
  >
      <input style="border-bottom: 1px solid #333;min-width:150px"
      type="number" name="" value=""  />
      <label  class="inputLabel">passenger tires</label>

      <input style="border-bottom: 1px solid #333;min-width:150px"
      type="number" name="" value=""  />
      <label class="inputLabel">Truck tires</label>
      
  </div>
 
</tr>
  </tbody>
</table>
</div>


<div class="" style="width: 100%;display:block ">

  <table style="width: 100%">
    <tbody>
        <td>
{{-- 3 part --}}

          <table style="">
            <tbody>
              <td >
                <tr>
                  <div class="row">
                    <h6 class="fw-bold text-uppercase mt-3" style="white-space: nowrap">
                      3. processor/recycler information and certification:
                    </h6>
                  </div>
                </tr>
    
                <tr class="">
                  <!-- registration number - driver's license number -->
                 
                    <div style="display: inline-flex;max-width:150px;" >
                      <input
    type="text"
    name=""
    value="{{$data->processor_reg_no ?? 'N/A'}}"
    class="inputField"
  />
  <label class="inputLabel">registration number</label>
</div>


    <div style="display: inline-flex;" >
      <input
        type="text"
        name=""
        style="min-width: 200px"
        class="inputField"
      />
      <label class="inputLabel" style="text-align: center">date and time of pickup</label>
    </div>

</tr>

<tr>
                  <!-- registration number - driver's license number -->
                 
                    <div style="display: inline-flex;min-width:100px;" >
                      <input
    type="text"
    name=""
    value=""
    class="inputField"
  />
  <label class="inputLabel">no. passenger tires</label>
</div>


    <div style="display: inline-flex;" >
      <input
        type="text"
        name=""
        value=""
        style="min-width: 60px"
        class="inputField"
      />
      <label class="inputLabel" style="text-align: center">no. truck tires</label>
    </div>
    <p class="fw-bold" style="margin-top: 7px;display: inline-flex;">OR</p>
    <div style="display: inline-flex;margin-left:5px" >
      <input
        type="text"
        name=""
        value=""
        style="min-width: 60px;"
        class="inputField"
      />
      <label class="inputLabel" style="text-align: center">weight of tires</label>
    </div>
    <span  style="display: inline-flex;">Lbs</span>
</tr>
</tr>

      <tr>
        <td>
          <div style="display: inline-block" >
            <input type="text" name="" value="" class="inputField" />
            <label class="inputLabel" style="white-space: nowrap">Area Code</label>
          </div>

          <div style="display: inline-flex;max-width:85%">
            <input type="text" name="" value="" class="inputField" />
            <label class="inputLabel">Telephone Number</label>
          </div>
        </td>
      </tr>

      <tr>
        <div class="d-flex flex-column">
          <input type="text" name="" value="" class="inputField" />
          <label class="inputLabel"
            >Company Name</label
          >
        </div>
      </tr>

      <tr>
        <div class="d-flex flex-column">
          <input type="text" name="" value="" class="inputField" />
          <label class="inputLabel"
            >Street Address</label
          >
        </div>
      </tr>

      <tr >
        <td style="justify-content:left">
          <div style="display: inline-flex;min-width:300px;" >
            <input type="text" name=""  class="inputField" />
            <label class="inputLabel" style="white-space: nowrap">City</label>
          </div>

          <div style="display: inline-flex">
            <input type="text" name="" value="" class="inputField" />
            <label class="inputLabel">State</label>
          </div>
          <div style="display: inline-flex">
            <input type="text" name="" value="" class="inputField" />
            <label class="inputLabel">Zip</label>
          </div>
        </td>
      </tr>


              </td>
            </tbody>
          </table>
        </td>


      <td>
        <table>
          <tbody>
            <td >
              <tr>
                <div class="row">
                  <h6 class="fw-bold text-uppercase mt-3" style="white-space: nowrap;margin-top: 60px!important;">
                    4. storage/disposal site information and certification:
                  </h6>
                </div>
              </tr>
  
              <tr class="mt-2" style="">
                <!-- registration number - driver's license number -->
               
                  <div style="display: inline-flex;max-width:150px;" >
                    <input
  type="text"
  name=""
  value="{{$data->storage_reg_no ?? 'N/A'}}"
  class="inputField"
/>
<label class="inputLabel">registration number</label>
</div>


  <div style="display: inline-flex;" >
    <input
      type="text"
      name=""
      value=""
      style="min-width: 200px"
      class="inputField"
    />
    <label class="inputLabel" style="text-align: center">date and time of pickup</label>
  </div>

</tr>

<tr>
                <!-- registration number - driver's license number -->
               
                  <div style="display: inline-flex;min-width:100px;" >
                    <input
  type="text"
  name=""
  value=""
  class="inputField"
/>
<label class="inputLabel">no. passenger tires</label>
</div>


  <div style="display: inline-flex;" >
    <input
      type="text"
      name=""
      value=""
      style="min-width: 60px"
      class="inputField"
    />
    <label class="inputLabel" style="text-align: center">no. truck tires</label>
  </div>
  <p class="fw-bold" style="margin-top: 7px;display: inline-flex;">OR</p>
  <div style="display: inline-flex;margin-left:5px" >
    <input
      type="text"
      name=""
      value=""
      style="min-width: 60px;"
      class="inputField"
    />
    <label class="inputLabel" style="text-align: center">weight of tires</label>
  </div>
  <span  style="display: inline-flex;">Lbs</span>
</tr>
</tr>

    <tr >
      <td>
        <div style="display: inline-block" >
          <input type="text" name="" value="" class="inputField" />
          <label class="inputLabel" style="white-space: nowrap">Area Code</label>
        </div>

        <div style="display: inline-flex;max-width:85%">
          <input type="text" name="" value="" class="inputField" />
          <label class="inputLabel">Telephone Number</label>
        </div>
      </td>
    </tr>
    

    <tr>
      <div class="d-flex flex-column">
        <input type="text" name="" value="" class="inputField" />
        <label class="inputLabel"
          >Company Name</label
        >
      </div>
    </tr>

    <tr>
      <div class="d-flex flex-column">
        <input type="text" name="" value="" class="inputField" />
        <label class="inputLabel"
          >Street Address</label
        >
      </div>
    </tr>

    <tr >
      <td style="justify-content:left">
        <div style="display: inline-flex;min-width:300px;" >
          <input type="text" name=""  class="inputField" />
          <label class="inputLabel" style="white-space: nowrap">City</label>
        </div>

        <div style="display: inline-flex">
          <input type="text" name="" value="" class="inputField" />
          <label class="inputLabel">State</label>
        </div>
        <div style="display: inline-flex">
          <input type="text" name="" value="" class="inputField" />
          <label class="inputLabel">Zip</label>
        </div>
      </td>
    </tr>


            </td>
          </tbody>
        </table>
      </td>
    </tbody>
  </table>
      

  <div class="col-12 ">
    <span class="fw-bold" style="font-size: 0.88rem; line-height: normal">
      I certify that the information provided above is true and correct
      and that I have been authorized by the Texas Natural Resource
      Conservation Commission accept whole used or scrap tires for
      storage, processing, or disposal. I am aware that falsification of
      this manifest may result in suspension, revocation. denial of
      renewal of my processing or storage site registration, or my
      disposal site permit.
    </span>
  </div>


<table style="width: 100%;"class="">
  <tbody>
    <tr>
      <td>
      <div class="col-6">
        <label 
        class="inputLabel"
        >signature</label>
      <input style="border-bottom: 1px solid #333;width:70%"
        type="number"
        name=""
        value=""
        class=""
      />
      </div>
    </td>

    <td>
      <div class="col-6">
        <label 
        class="inputLabel"
        >signature</label>
      <input style="border-bottom: 1px solid #333;width:70%"
        type="number"
        name=""
        value=""
        class=""
      />
      </div>
    </td>
    </tr>

    <tr>
      <td>
        <div class="col-6">
          <label 
          class="inputLabel"
          >print name</label>
        
        @if($data->customer_signature)
        <img style="display:inline-block;width:70%;border:none;border-bottom:1px solid #333;" src="{{$data->customer_signature}}" class="" alt="">
      @endif
        </div>
      </td>
  
      <td>
        <div class="col-6">
          <label 
          class="inputLabel"
          >print name</label>
      
        @if($data->customer_signature)
          <img style="display:inline-block;width:70%;border:none;border-bottom:1px solid #333;" src="{{$data->customer_signature}}" class="" alt="">
        @endif
        </div>
      </td>
    </tr>
  </tbody>
</table>

<div class="col-12 ">
  <span class="fw-bold" style="font-size: 0.88rem; line-height: normal">
    A copy of each transaction must be retained by each party for a
    period of three years. The processor or disposal facility operator
    must mail a copy of t completed manifest back to the generator.
    Following each transaction, the copy separated from the manifest
    should be the bottom copy. (Green-Generator yellow-transporter,
    blue-processor; pink-disposal facility, white original-generator)
  </span>
</div>
<div class="w-100 text-center" style="width: 100%;">
  <span class="fw-bold"  style="text-align: center;color:red;">Generator</span>
</div>

      
</div>




   
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
