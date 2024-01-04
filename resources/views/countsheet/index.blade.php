<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Two-Column Grid with 4 and 3 Columns</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: sans-serif;
        }

        body {
            padding: 40px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 2px solid rgb(0, 0, 0);
            padding: 8px;
            text-align: left;
            font-weight: bold;
        }

        th {
            background-color: #e6e6e6;
        }

        .left-column {
            width: 55%;
        }

        .right-column {
            width: 45%;
        }

        .blue {
            background-color: #c8f8fb;
        }

        .green {
            background-color: #89bf71;
        }

        .purple {
            background-color: #8088b9;
        }

        .darkpurple {
            background-color: #636da5;
        }

        .gray {
            background-color: #e6e6e6;
        }

        .red {
            background-color: red !important;
        }

        .btn1 {
            padding: 5px;
            height: 40px;
            background-color: #c8f8fb;
            color: black;
            width: 30%;
            font-weight: bold;
            border: 2px solid black;
            margin-top: 100px;
            margin-bottom: 80px;
        }

        .btn2 {
            padding: 5px;
            height: 40px;
            background-color: #89bf71;
            color: black;
            font-weight: bold;
            width: 30%;
            border: 2px solid black;
            margin-top: 100px;
            margin-bottom: 80px;
        }

        .btn3 {
            padding: 5px;
            height: 40px;
            background-color: #636da5;
            color: black;
            font-weight: bold;
            border: 2px solid black;
            width: 30%;
            margin-top: 100px;
            margin-bottom: 80px;
        }

        .btn4 {
            padding: 5px;
            height: 45px;
            background-color: #e6e6e6;
            color: black;
            font-weight: bold;
            border: 2px solid black;
            width: 70%;
            margin-bottom: 25px;
        }
    </style>
</head>

<body>
    <h2 style="text-align: center">Driver Count and Calculations Table</h2>
    <p style="margin-top: 40px; margin-bottom: 30px">Pick Up Earliest Time ____</p>
    @php
        $typesOfPassangerTires = !empty($data->fulfilled->type_of_passenger) ? json_decode($data->fulfilled->type_of_passenger, true) : [];
        $typesOfTruckTires = !empty($data->fulfilled->type_of_truck_tyre) ? json_decode($data->fulfilled->type_of_truck_tyre, true) : [];
        $typesOfAgriTires = !empty($data->fulfilled->type_of_agri_tyre) ? json_decode($data->fulfilled->type_of_agri_tyre, true) : [];
        $typesOfOtherTires = !empty($data->fulfilled->type_of_other) ? json_decode($data->fulfilled->type_of_other, true) : [];

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

        //for dock manager

        $dockTypesOfPassangerTires = !empty($data->compared->type_of_passenger) ? json_decode($data->compared->type_of_passenger, true) : [];
        $dockTypesOfTruckTires = !empty($data->compared->type_of_truck_tyre) ? json_decode($data->compared->type_of_truck_tyre, true) : [];
        $dockTypesOfAgriTires = !empty($data->compared->type_of_agri_tyre) ? json_decode($data->compared->type_of_agri_tyre, true) : [];
        $dockTypesOfOtherTires = !empty($data->compared->type_of_other) ? json_decode($data->compared->type_of_other, true) : [];

        //for single passanger
        $dockLawnmowers_atvmotorcycle = 0;
        $dockLawnmowers_atvmotorcyclewithrim = 0;
        $dockPassanger_lighttruck = 0;
        $dockPassanger_lighttruckwithrim = 0;
        foreach ($dockTypesOfPassangerTires as $item) {
            foreach ($item as $key => $value) {
                if ($key == 'lawnmowers_atvmotorcycle') {
                    $dockLawnmowers_atvmotorcycle = $value;
                } elseif ($key == 'lawnmowers_atvmotorcyclewithrim') {
                    $dockLawnmowers_atvmotorcyclewithrim = $value;
                } elseif ($key == 'passanger_lighttruck') {
                    $dockPassanger_lighttruck = $value;
                } elseif ($key == 'passanger_lighttruckwithrim') {
                    $dockPassanger_lighttruckwithrim = $value;
                }
            }
        }
        //for single truck
        $dock_semi_truck = 0;
        $dock_semi_super_singles = 0;
        $dock_semi_truck_with_rim = 0;
        foreach ($dockTypesOfTruckTires as $item) {
            foreach ($item as $key => $value) {
                if ($key == 'semi_truck') {
                    $dock_semi_truck = $value;
                } elseif ($key == 'semi_super_singles') {
                    $dock_semi_super_singles = $value;
                } elseif ($key == 'semi_truck_with_rim') {
                    $dock_semi_truck_with_rim = $value;
                }
            }
        }

        // for single agri

        $dock_ag_med_truck_19_5_skid_steer = 0;
        $dock_ag_med_truck_19_5_with_rim = 0;
        $dock_farm_tractor_last_two_digits = 0;

        foreach ($dockTypesOfAgriTires as $item) {
            foreach ($item as $key => $value) {
                if ($key == 'ag_med_truck_19_5_skid_steer') {
                    $dock_ag_med_truck_19_5_skid_steer = $value;
                } elseif ($key == 'ag_med_truck_19_5_with_rim') {
                    $dock_ag_med_truck_19_5_with_rim = $value;
                } elseif ($key == 'farm_tractor_last_two_digits') {
                    $dock_farm_tractor_last_two_digits = $value;
                }
            }
        }

        $dock_15_5_24 = 0;
        $dock_17_5_25 = 0;
        $dock_20_5_25 = 0;
        $dock_23_5_25 = 0;
        $dock_26_5_25 = 0;
        $dock_29_5_25 = 0;
        $dock_24_00R35 = 0;
        $dock_13_00_24 = 0;
        $dock_14_00_24 = 0;
        $dock_19_5L_24 = 0;
        foreach ($dockTypesOfOtherTires as $item) {
            foreach ($item as $key => $value) {
                switch ($key) {
                    case '15_5_24':
                        $dock_15_5_24 = $value;
                        break;
                    case '17_5_25':
                        $dock_17_5_25 = $value;
                        break;
                    case '20_5_25':
                        $dock_20_5_25 = $value;
                        break;
                    case '23_5_25':
                        $dock_23_5_25 = $value;
                        break;
                    case '26_5_25':
                        $dock_26_5_25 = $value;
                        break;
                    case '29_5_25':
                        $dock_29_5_25 = $value;
                        break;
                    case '24_00R35':
                        $dock_24_00R35 = $value;
                        break;
                    case '13_00_24':
                        $dock_13_00_24 = $value;
                        break;
                    case '14_00_24':
                        $dock_14_00_24 = $value;
                        break;
                    case '19_5L_24':
                        $dock_19_5L_24 = $value;
                        break;

                    default:
                        # code...
                        break;
                }
            }
        }

    @endphp
    <table>
        <tr>
            <!-- Left Column with 4 Columns -->
            <td class="left-column">
                <table>
                    <h3>Driver & Customer Count</h3>
                    <thead>
                        <tr>
                            <th>Passenger</th>
                            <th>Quantity</th>
                            <th>Charge each</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Tubes</td>
                            <td class=""></td>
                            <td>1.00$</td>
                            <td>$ 0.00</td>
                        </tr>
                        <tr class="{{ $lawnmowers_atvmotorcycle == $dockLawnmowers_atvmotorcycle ? '' : 'red' }} ">
                            <td>Lawnmowers/ATV/Motorcycle</td>
                            <td class="">{{ $lawnmowers_atvmotorcycle }}</td>
                            <td class=""></td>
                            <td>$ 0.00</td>
                        </tr>
                        <tr
                            class="{{ $lawnmowers_atvmotorcyclewithrim == $dockLawnmowers_atvmotorcyclewithrim ? '' : 'red' }} ">
                            <td>Lawnmowers/ATV/Motorcycle with RIM</td>
                            <td class="">{{ $lawnmowers_atvmotorcyclewithrim }}</td>
                            <td>$25.00</td>
                            <td>$ 0.00</td>
                        </tr>
                        <tr class="{{ $passanger_lighttruck == $dockPassanger_lighttruck ? '' : 'red' }} ">
                            <td>Passenger/Light</td>
                            <td class="">{{ $passanger_lighttruck }}</td>
                            <td class=""></td>
                            <td>$ 0.00</td>
                        </tr>
                        <tr
                            class="{{ $passanger_lighttruckwithrim == $dockPassanger_lighttruckwithrim ? '' : 'red' }} ">
                            <td>Passenger/Light truck with Rim</td>
                            <td class="">{{ $passanger_lighttruckwithrim }}</td>
                            <td>$25.00</td>
                            <td>$ 0.00</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class=""></td>
                            <td>Passenger Total</td>
                            <td>$ 0.00</td>
                        </tr>
                        <!-- new head -->
                        <thead>
                            <tr>
                                <th>Truck/Semi</th>
                                <th>Quantity</th>
                                <th>Charge each</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                    </tbody>

                    <tbody>
                        <tr class="{{ $semi_truck == $dock_semi_truck ? '' : 'red' }} ">
                            <td>Semi Truck</td>
                            <td class="">{{ $semi_truck }}</td>
                            <td class=""></td>
                            <td>$ 0.00</td>
                        </tr>
                        <tr class="{{ $semi_super_singles == $dock_semi_super_singles ? '' : 'red' }} ">
                            <td>Semi super single</td>
                            <td class="">{{ $semi_super_singles }}</td>
                            <td>$ 18.00</td>
                            <td>$ 0.00</td>
                        </tr>

                        <tr class="{{ $semi_truck_with_rim == $dock_semi_truck_with_rim ? '' : 'red' }} ">
                            <td>Semi Truck with RIM</td>
                            <td class="">{{ $semi_truck_with_rim }}</td>
                            <td>$75.00</td>
                            <td>$ 0.00</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class=""></td>
                            <td>Passenger Total</td>
                            <td>$ 0.00</td>
                        </tr>
                        <!-- Add more rows as needed -->
                        <!-- new head -->
                        <thead>
                            <tr>
                                <th>Agri</th>
                                <th>Quantity</th>
                                <th>Charge each</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                    </tbody>

                    <tbody>
                        <tr
                            class="{{ $ag_med_truck_19_5_skid_steer == $dock_ag_med_truck_19_5_skid_steer ? '' : 'red' }} ">
                            <td>AG Med Truck 19.5/ Skid Steer</td>
                            <td class="">{{ $ag_med_truck_19_5_skid_steer }}</td>
                            <td class="green"></td>
                            <td>$ 0.00</td>
                        </tr>
                        <tr
                            class="{{ $ag_med_truck_19_5_with_rim == $dock_ag_med_truck_19_5_with_rim ? '' : 'red' }} ">
                            <td>AG Med Truck 19.5/ with Rim</td>
                            <td class="">
                                {{ $ag_med_truck_19_5_with_rim }}</td>
                            <td>$ 48.00</td>
                            <td>$ 0.00</td>
                        </tr>

                        <tr
                            class="{{ $farm_tractor_last_two_digits == $dock_farm_tractor_last_two_digits ? '' : 'red' }} ">
                            <td>Farm Tractor $1.25 per, Last two digits</td>
                            <td class="">{{ $farm_tractor_last_two_digits }}</td>
                            <td>$1.25</td>
                            <td>$ 0.00</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class=""></td>
                            <td>Agri Total</td>
                            <td>$ 0.00</td>
                        </tr>
                    </tbody>
                    <!-- Add more rows as needed -->
                    <!-- new head -->
                    <thead>
                        <tr>
                            <th>OTR</th>
                            <th>Quantity</th>
                            <th>Charge each</th>
                            <th>Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr class="{{ $driver_15_5_24 == $dock_15_5_24 ? '' : 'red' }} ">
                            <td>15.5-25</td>
                            <td class="blue">{{ $driver_15_5_24 }}</td>
                            <td>$65.00</td>
                            <td>$ 0.00</td>
                        </tr>
                        <tr class="{{ $driver_17_5_25 == $dock_17_5_25 ? '' : 'red' }} ">
                            <td>17,5-25 (Radial)</td>
                            <td class="blue">{{ $driver_17_5_25 }}</td>
                            <td>$95.00</td>
                            <td>$ 0.00</td>
                        </tr>
                        <tr class="{{ $driver_20_5_25 == $dock_20_5_25 ? '' : 'red' }} ">
                            <td>20.5-25 (Radial)</td>
                            <td class="blue">{{ $driver_20_5_25 }}</td>
                            <td>$125.00</td>
                            <td>$ 0.00</td>
                        </tr>
                        <tr class="{{ $driver_23_5_25 == $dock_23_5_25 ? '' : 'red' }} ">
                            <td>23.5-25 (Radial)</td>
                            <td class="blue">{{ $driver_23_5_25 }}</td>
                            <td>$145.00</td>
                            <td>$ 0.00</td>
                        </tr>
                        <tr class="{{ $driver_26_5_25 == $dock_26_5_25 ? '' : 'red' }} ">
                            <td>26.5-25 (Radial)</td>
                            <td class="blue">{{ $driver_26_5_25 }}</td>
                            <td>$165.00</td>
                            <td>$ 0.00</td>
                        </tr>
                        <tr class="{{ $driver_29_5_25 == $dock_29_5_25 ? '' : 'red' }} ">
                            <td>29.5-25 (Radial)</td>
                            <td class="blue">{{ $driver_29_5_25 }}</td>
                            <td>$185.00</td>
                            <td>$ 0.00</td>
                        </tr>
                        <tr class="{{ $driver_24_00R35 == $dock_24_00R35 ? '' : 'red' }} ">
                            <td>24.00 R35</td>
                            <td class="blue">{{ $driver_24_00R35 }}</td>
                            <td>$200.00</td>
                            <td>$ 0.00</td>
                        </tr>
                        <tr class="{{ $driver_13_00_24 == $dock_13_00_24 ? '' : 'red' }} ">
                            <td>13.00 -24</td>
                            <td class="blue">{{ $driver_13_00_24 }}</td>
                            <td>$30.00</td>
                            <td>$ 0.00</td>
                        </tr>
                        <tr>
                            <td>14.5-25 (Radial)</td>
                            <td class="blue"></td>
                            <td>$30.00</td>
                            <td>$ 0.00</td>
                        </tr>
                        <tr class="{{ $driver_14_00_24 == $dock_14_00_24 ? '' : 'red' }} ">
                            <td>14.00-24 (Radial)</td>
                            <td class="blue">{{ $driver_14_00_24 }}</td>
                            <td>$30.00</td>
                            <td>$ 0.00</td>
                        </tr>
                        <tr class="{{ $driver_19_5L_24 == $dock_19_5L_24 ? '' : 'red' }} ">
                            <td>19.5L -24</td>
                            <td class="blue">{{ $driver_19_5L_24 }}</td>
                            <td>$30.00</td>
                            <td>$ 0.00</td>
                        </tr>
                        <tr>
                            <td>18.5L -24</td>
                            <td class="blue"></td>
                            <td>$30.00</td>
                            <td>$ 0.00</td>
                        </tr>
                        <tr>
                            <td>18.4 -38</td>
                            <td class="blue"></td>
                            <td>$48.00</td>
                            <td>$ 0.00</td>
                        </tr>
                        <tr>
                            <td>520/80R46</td>
                            <td class="blue"></td>
                            <td>$58.00</td>
                            <td>$ 0.00</td>
                        </tr>
                        <tr>
                            <td>480/80R50</td>
                            <td class="blue"></td>
                            <td>$63.00</td>
                            <td>$ 0.00</td>
                        </tr>
                        <tr>
                            <td>710/70R43</td>
                            <td class="blue"></td>
                            <td>$63.00</td>
                            <td>$ 0.00</td>
                        </tr>
                        <tr>
                            <td>Odd Tire</td>
                            <td class="blue"></td>
                            <td class="blue"></td>
                            <td>$ 0.00</td>
                        </tr>

                        <tr>
                            <td colspan="1"></td>
                            <td colspan="2" style="text-align: right">Other Total</td>
                            <td colspan="1">$ 0.00</td>
                        </tr>
                        <tr>
                            <td colspan="1">PU #:</td>
                            <td colspan="2" class="gray">Passenger Total $</td>
                            <td colspan="1" class="blue">$0.00</td>
                        </tr>
                        <tr>
                            <td colspan="1">Drop #:</td>
                            <td colspan="2" class="gray">Truck Total $</td>
                            <td colspan="1" class="blue">$0.00</td>
                        </tr>
                        <tr>
                            <td colspan="1">PO #:</td>
                            <td colspan="2" class="gray">Agri Total $</td>
                            <td colspan="1" class="blue">$0.00</td>
                        </tr>
                        <tr>
                            <td colspan="1">Start Weight #:</td>
                            <td colspan="2" class="gray">Other Total $</td>
                            <td colspan="1" class="blue">$0.00</td>
                        </tr>
                        <tr>
                            <td colspan="1">End Weight #:</td>
                            <td colspan="2" class="gray">Sub Total $</td>
                            <td colspan="1" class="">$0.00</td>
                        </tr>
                        <tr>
                            <td colspan="1">Check #:</td>
                            <td colspan="2" class="gray">Tax %</td>
                            <td colspan="1" class="green"></td>
                        </tr>
                        <tr>
                            <td colspan="1">Charge Around:</td>
                            <td colspan="2" class="gray">After Tax Total</td>
                            <td colspan="1" class="">$0.00</td>
                        </tr>
                        <tr>
                            <td colspan="1">Credit Card:</td>
                            <td colspan="2" class="gray">Convienience Fee 4%</td>
                            <td colspan="1" class=""></td>
                        </tr>
                        <tr>
                            <td colspan="1">Cash</td>
                            <td colspan="2" class="gray">Total Due</td>
                            <td colspan="1" class="">$0.00</td>
                        </tr>
                    </tbody>
                </table>
            </td>

            <!-- Right Column with 3 Columns -->
            <td class="right-column">
                <table>
                    <h3>2nd Count/Rowdy</h3>
                    <thead>
                        <tr>
                            <th>Passenger</th>
                            <th>Quantity</th>
                            <th>REUSE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Tubes</td>
                            <td class="purple"></td>
                            <td class="darkpurple"></td>
                        </tr>
                        <tr class="{{ $lawnmowers_atvmotorcycle == $dockLawnmowers_atvmotorcycle ? '' : 'red' }} ">
                            <td>Lawnmowers/ATV/Motorcycle</td>
                            <td class="purple">{{ $dockLawnmowers_atvmotorcycle }}</td>
                            <td class="darkpurple"></td>
                        </tr>
                        <tr
                            class="{{ $lawnmowers_atvmotorcyclewithrim == $dockLawnmowers_atvmotorcyclewithrim ? '' : 'red' }} ">
                            <td>Lawnmowers/ATV/Motorcycle with RIM</td>
                            <td class="purple">{{ $dockLawnmowers_atvmotorcyclewithrim }}</td>
                            <td class="darkpurple"></td>
                        </tr>
                        <tr class="{{ $passanger_lighttruck == $dockPassanger_lighttruck ? '' : 'red' }} ">
                            <td>Passenger/Light</td>
                            <td class="purple">{{ $dockPassanger_lighttruck }}</td>
                            <td class="darkpurple"></td>
                        </tr>
                        <tr
                            class="{{ $passanger_lighttruckwithrim == $dockPassanger_lighttruckwithrim ? '' : 'red' }} ">
                            <td>Passenger/Light truck with Rim</td>
                            <td class="purple">{{ $dockPassanger_lighttruckwithrim }}</td>
                            <td class="darkpurple"></td>
                        </tr>
                        <tr>
                            <td style="color: white">asd</td>
                            <td class=""></td>
                            <td class=""></td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>

                    <!-- new head -->
                    <thead>
                        <tr>
                            <th>Truck/Semi</th>
                            <th>Quantity</th>
                            <th>REUSE</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr class="{{ $semi_truck == $dock_semi_truck ? '' : 'red' }} ">
                            <td>Semi Truck</td>
                            <td class="purple">{{ $dock_semi_truck }}</td>
                            <td class="darkpurple"></td>
                        </tr>
                        <tr class="{{ $semi_super_singles == $dock_semi_super_singles ? '' : 'red' }} ">
                            <td>Semi Super Singles</td>
                            <td class="purple">{{ $dock_semi_super_singles }}</td>
                            <td class="darkpurple"></td>
                        </tr>
                        <tr class="{{ $semi_truck_with_rim == $dock_semi_truck_with_rim ? '' : 'red' }} ">
                            <td>Semi Truck with RIM </td>
                            <td class="purple">{{ $dock_semi_truck_with_rim }}</td>
                            <td class="darkpurple"></td>
                        </tr>
                        <tr>
                            <td style="color: white">asd</td>
                            <td class=""></td>
                            <td class=""></td>
                        </tr>
                        <!-- Add more rows as needed -->
                        <thead>
                            <tr>
                                <th>Agri</th>
                                <th>Quantity</th>
                                <th>REUSE</th>
                            </tr>
                        </thead>
                    </tbody>

                    <tbody>
                        <tr
                            class="{{ $ag_med_truck_19_5_skid_steer == $dock_ag_med_truck_19_5_skid_steer ? '' : 'red' }} ">
                            <td>AG Med Truck 19.5/ Skid Steer</td>
                            <td class="purple">{{ $dock_ag_med_truck_19_5_skid_steer }}</td>
                            <td class="darkpurple"></td>
                        </tr>
                        <tr
                            class="{{ $ag_med_truck_19_5_with_rim == $dock_ag_med_truck_19_5_with_rim ? '' : 'red' }} ">
                            <td>AG Med Truck 19.5/ with Rim</td>
                            <td class="purple">{{ $dock_ag_med_truck_19_5_with_rim }}</td>
                            <td class="darkpurple"></td>
                        </tr>
                        <tr
                            class="{{ $farm_tractor_last_two_digits == $dock_farm_tractor_last_two_digits ? '' : 'red' }} ">
                            <td>Farm Tractor $1.25 per, Last two digits</td>
                            <td class="purple">{{ $dock_farm_tractor_last_two_digits }}</td>
                            <td class="darkpurple"></td>
                        </tr>


                    </tbody>
                    {{-- $dock_15_5_24 = 0; $dock_17_5_25=0; $dock_20_5_25=0; $dock_23_5_25 =0; $dock_26_5_25 = 0 ;
                    $dock_29_5_25 =0; $dock_24_00R35 =0; $dock_13_00_24 =0; $dock_14_00_24 =0;$dock_19_5L_24 =0; --}}
                    <tbody>
                        <thead>
                            <tr>
                                <th>OTR</th>
                                <th>Quantity</th>
                                <th>REUSE</th>
                            </tr>
                        </thead>
                        <tr class="{{ $driver_15_5_24 == $dock_15_5_24 ? '' : 'red' }} ">
                            <td>15.5-25</td>
                            <td class="purple">{{ $dock_15_5_24 }}</td>
                            <td class="darkpurple"></td>
                        </tr>
                        <tr class="{{ $driver_17_5_25 == $dock_17_5_25 ? '' : 'red' }} ">
                            <td>17,5-25 (Radial)</td>
                            <td class="purple">{{ $dock_17_5_25 }}</td>
                            <td class="darkpurple"></td>
                        </tr>
                        <tr class="{{ $driver_20_5_25 == $dock_20_5_25 ? '' : 'red' }} ">
                            <td>20.5-25 (Radial)</td>
                            <td class="purple">{{ $dock_20_5_25 }}</td>
                            <td class="darkpurple"></td>
                        </tr>
                        <tr class="{{ $driver_23_5_25 == $dock_23_5_25 ? '' : 'red' }} ">
                            <td>23.5-25 (Radial)</td>
                            <td class="purple">{{ $dock_23_5_25 }}</td>
                            <td class="darkpurple"></td>
                        </tr>
                        <tr class="{{ $driver_26_5_25 == $dock_26_5_25 ? '' : 'red' }} ">
                            <td>26.5-25 (Radial)</td>
                            <td class="purple">{{ $dock_26_5_25 }}</td>
                            <td class="darkpurple"></td>
                        </tr>
                        <tr class="{{ $driver_29_5_25 == $dock_29_5_25 ? '' : 'red' }} ">
                            <td>29.5-25 (Radial)</td>
                            <td class="purple">{{ $dock_29_5_25 }}</td>
                            <td class="darkpurple"></td>
                        </tr>
                        <tr class="{{ $driver_24_00R35 == $dock_24_00R35 ? '' : 'red' }} ">
                            <td>24.00 R35</td>
                            <td class="purple">{{ $dock_24_00R35 }}</td>
                            <td class="darkpurple"></td>
                        </tr>
                        <tr class="{{ $driver_13_00_24 == $dock_13_00_24 ? '' : 'red' }} ">
                            <td>13.00 -24</td>
                            <td class="purple">{{ $dock_13_00_24 }}</td>
                            <td class="darkpurple"></td>
                        </tr>
                        <tr >
                            <td>14.5-25 (Radial)</td>
                            <td class="purple"></td>
                            <td class="darkpurple"></td>
                        </tr>
                        <tr class="{{ $driver_14_00_24 == $dock_14_00_24 ? '' : 'red' }} ">
                            <td>14.00-24 (Radial)</td>
                            <td class="purple">{{ $dock_14_00_24 }}</td>
                            <td class="darkpurple"></td>
                        </tr>
                        <tr class="{{ $driver_19_5L_24 == $dock_19_5L_24 ? '' : 'red' }} ">
                            <td>19.5L -24</td>
                            <td class="purple">{{ $dock_19_5L_24 }}</td>
                            <td class="darkpurple"></td>
                        </tr>
                        <tr>
                            <td>18.5L -24</td>
                            <td class="purple"></td>
                            <td class="darkpurple"></td>
                        </tr>
                        <tr>
                            <td>18.4 -38</td>
                            <td class="purple"></td>
                            <td class="darkpurple"></td>
                        </tr>
                        <tr>
                            <td>520/80R46</td>
                            <td class="purple"></td>
                            <td class="darkpurple"></td>
                        </tr>
                        <tr>
                            <td>480/80R50</td>
                            <td class="purple"></td>
                            <td class="darkpurple"></td>
                        </tr>
                        <tr>
                            <td>710/70R43</td>
                            <td class="purple"></td>
                            <td class="darkpurple"></td>
                        </tr>
                        <tr>
                            <td>Odd Tire</td>
                            <td class="purple"></td>
                            <td class="darkpurple"></td>
                        </tr>

                        <tr>
                            <td></td>
                            <td></td>
                            <td style="color: white">.</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="color: white">.</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="color: white">.</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="color: white">.</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="color: white">.</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="color: white">.</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="color: white">.</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="color: white">.</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="color: white">.</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="color: white">.</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="color: white">.</td>
                        </tr>
                        <tr style="text-align: center">
                            <td colspan="4" style="border: 1px solid white; text-align: center">
                                {{-- <button class="btn1">Driver Filled</button>
                                <button class="btn2">Front Desk Filled</button>

                                <button class="btn3">Rowdy/Dock Filled</button> --}}
                            </td>
                        </tr>

                    </tbody>
                </table>
            </td>
        </tr>
    </table>

    {{-- <div style="height: 300px;display:none"></div>

    <table style="display: none">
        <table>
            <thead>
                <tr>
                    <th>Passenger</th>
                    <th>Quantity</th>
                    <th>Weight Each</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Tubes</td>
                    <td class="blue"></td>
                    <td class=""></td>

                    <td>0</td>
                </tr>
                <tr>
                    <td>Lawnmowers/ATV/Motorcycle</td>
                    <td class="blue"></td>
                    <td style="text-align: right;">15</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>Lawnmowers/ATV/Motorcycle with RIM</td>
                    <td class="blue"></td>
                    <td style="text-align: right;">25</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>Passenger/Light</td>
                    <td class="blue"></td>
                    <td style="text-align: right;">15</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>Passenger/Light truck with Rim</td>
                    <td class="blue"></td>
                    <td style="text-align: right;">25</td>
                    <td> 0</td>
                </tr>
                <tr style="border: none;">
                    <td style="border: none;" colspan="2"></td>
                    <td style="text-align: right;">Passenger Total</td>
                    <td>0</td>
                </tr>

            </tbody>
        </table>
        <table>
            <tbody>
                <thead>
                    <tr>
                        <th>Semi/Truck</th>
                        <th>Quantity</th>
                        <th>Weight each</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tr>
                    <td>Semi Truck</td>
                    <td class="blue"></td>
                    <td style="text-align: right;">110</td>
                    <td>$ 0.00</td>
                </tr>
                <tr>
                    <td>Semi super single</td>
                    <td class="blue"></td>
                    <td style="text-align: right;" class="">110</td>
                    <td>$ 0.00</td>
                </tr>
                <tr>
                    <td>Semi Truck with Rim</td>
                    <td class="blue"></td>
                    <td style="text-align: right;">125</td>
                    <td>$ 0.00</td>
                </tr>
                <tr style="border: none;">
                    <td style="border: none;" colspan="2"></td>
                    <td style="text-align: left;">Truck Total</td>
                    <td>0</td>
                </tr>
                <!-- Add more rows as needed -->
            </tbody>
        </table>
        <table>
            <tbody>
                <thead>
                    <tr>
                        <th>Agri</th>
                        <th>Quantity</th>
                        <th>Weight each</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tr>
                    <td>AG Med Truck 19.5/ Skid steer</td>
                    <td class="blue"></td>
                    <td style="text-align: right;">60</td>
                    <td>$ 0.00</td>
                </tr>
                <tr>
                    <td>AG Med Truck 19.5/ with Rim</td>
                    <td class="blue"></td>
                    <td style="text-align: right;" class="">60</td>
                    <td>$ 0.00</td>
                </tr>
                <tr>
                    <td>Farm Tractor $1.25 per, Last two digits</td>
                    <td class="blue"></td>
                    <td style="text-align: right;">5</td>
                    <td>$ 0.00</td>
                </tr>
                <tr>
                    <td></td>
                    <td class="blue"></td>
                    <td></td>
                    <td>$ 0.00</td>
                </tr>
                <tr>
                    <td></td>
                    <td class="blue"></td>
                    <td></td>
                    <td>$ 0.00</td>
                </tr>
                <tr>
                    <td></td>
                    <td class="blue"></td>
                    <td></td>
                    <td>$ 0.00</td>
                </tr>
                <tr>
                    <td></td>
                    <td class="blue"></td>
                    <td></td>
                    <td>$ 0.00</td>
                </tr>
                <tr>
                    <td></td>
                    <td class="blue"></td>
                    <td></td>
                    <td>$ 0.00</td>
                <tr style="border: none;">
                    <td style="border: none;" colspan="2"></td>
                    <td style="text-align: left;">Agri Total</td>
                    <td>0</td>
                </tr>
                <!-- Add more rows as needed -->
            </tbody>
        </table>
        <table>
            <tbody>
                <thead>
                    <tr>
                        <th>OTR</th>
                        <th>Quantity</th>
                        <th>Weight each</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tr>
                    <td>15.5-25</td>
                    <td class="blue"></td>
                    <td style="text-align: right;">158</td>
                    <td>$ 0.00</td>
                </tr>
                <tr>
                    <td>15.5-25(Radial)</td>
                    <td class="blue"></td>
                    <td style="text-align: right;" class="">300</td>
                    <td>$ 0.00</td>
                </tr>
                <tr>
                    <td>20.5-25(Radial)</td>
                    <td class="blue"></td>
                    <td style="text-align: right;">330</td>
                    <td>$ 0.00</td>
                </tr>

                <tr>
                    <td>23.5-25(Radial)</td>
                    <td class="blue"></td>
                    <td style="text-align: right;">551</td>
                    <td>$ 0.00</td>
                </tr>
                <tr>
                    <td>26.5-25(Radial)</td>
                    <td class="blue"></td>
                    <td style="text-align: right;">1000</td>
                    <td>$ 0.00</td>
                </tr>
                <td>29.5-25(Radial)</td>
                <td class="blue"></td>
                <td style="text-align: right;">1279</td>
                <td>$ 0.00</td>
                </tr>
                <td>24.00R35</td>
                <td class="blue"></td>
                <td style="text-align: right;">1816</td>
                <td>$ 0.00</td>
                </tr>
                <td>13.00-24</td>
                <td class="blue"></td>
                <td style="text-align: right;">158</td>
                <td>$ 0.00</td>
                </tr>
                </tr>
                <td>14.00-24(Radial)</td>
                <td class="blue"></td>
                <td style="text-align: right;">293</td>
                <td>$ 0.00</td>
                </tr>
                </tr>
                <td>19.5L-24</td>
                <td class="blue"></td>
                <td style="text-align: right;">192</td>
                <td>$ 0.00</td>
                </tr>
                </tr>
                <td>18.4-30</td>
                <td class="blue"></td>
                <td style="text-align: right;">209</td>
                <td>$ 0.00</td>
                </tr>
                </tr>
                <td>18.4-38</td>
                <td class="blue"></td>
                <td style="text-align: right;">271</td>
                <td>$ 0.00</td>
                </tr>
                </tr>
                <td>520/80R46</td>
                <td class="blue"></td>
                <td style="text-align: right;">465</td>
                <td>$ 0.00</td>
                </tr>
                </tr>
                <td>480/80R50</td>
                <td class="blue"></td>
                <td style="text-align: right;">500</td>
                <td>$ 0.00</td>
                </tr>
                </tr>
                <td>710/70R43</td>
                <td class="blue"></td>
                <td style="text-align: right;">741</td>
                <td>$ 0.00</td>
                </tr>
                </tr>
                <td>Odd Tire/inches</td>
                <td class="blue"></td>
                <td style="text-align: right;">6</td>
                <td>$ 0.00</td>
                </tr>
                </tr>
                <td>Odd Tire/inches</td>
                <td class="blue"></td>
                <td style="text-align: right;">6</td>
                <td>$ 0.00</td>
                </tr>
                <tr style="border: none;">
                    <td style="border: none;" colspan="2"></td>
                    <td style="text-align: left;">Other Total</td>
                    <td>0</td>
                </tr>

                <!-- Add more rows as needed -->
                <tr style="border: none;">
                    <td style="border: none;" colspan="2"></td>
                </tr>


                <tr style="border: none;">
                    <td style="border: none;" colspan="2"></td>
                    <td style="text-align: left;">Passenger Total lbs</td>
                    <td>0</td>
                </tr>
                <tr style="border: none;">
                    <td style="border: none;" colspan="2"></td>
                    <td style="text-align: left;">Truck Total lbs</td>
                    <td>0</td>
                </tr>
                <tr style="border: none;">
                    <td style="border: none;" colspan="2"></td>
                    <td style="text-align: left;">Agri Total lbs</td>
                    <td>0</td>
                </tr>
                <tr style="border: none;">
                    <td style="border: none;" colspan="2"></td>
                    <td style="text-align: left;">Other Total lbs</td>
                    <td>0</td>
                </tr>
                <tr style="border: none;">
                    <td style="border: none;" colspan="2"></td>
                    <td style="text-align: left;">Total lbs</td>
                    <td>0</td>
                </tr>
            </tbody>

        </table>
    </table> --}}

</body>

</html>
