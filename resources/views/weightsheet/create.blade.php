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
            border-collapse: collapse;
            margin-top: 20px;
            width: 100%
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
    </style>
</head>

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

@endphp

<body>
    <table>
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
                {{-- <tr>
                    <td>Tubes</td>
                    <td class="blue"></td>
                    <td class=""></td>

                    <td>0</td>
                </tr> --}}
                <tr>
                    <td>Lawnmowers/ATV/Motorcycle</td>
                    <td class="blue">{{ $lawnmowers_atvmotorcycle }}</td>
                    <td style="text-align: right;">15</td>
                    <td>{{ $lawnmowers_atvmotorcycle * 15 }}</td>
                </tr>
                <tr>
                    <td>Lawnmowers/ATV/Motorcycle with RIM</td>
                    <td class="blue">{{ $lawnmowers_atvmotorcyclewithrim }}</td>
                    <td style="text-align: right;">25</td>
                    <td>{{ $lawnmowers_atvmotorcyclewithrim * 25 }}</td>
                </tr>
                <tr>
                    <td>Passenger/Light</td>
                    <td class="blue">{{ $passanger_lighttruck }}</td>
                    <td style="text-align: right;">15</td>
                    <td>{{ $passanger_lighttruck * 15 }}</td>
                </tr>
                <tr>
                    <td>Passenger/Light truck with Rim</td>
                    <td class="blue">{{ $passanger_lighttruckwithrim }}</td>
                    <td style="text-align: right;">25</td>
                    <td>{{ $passanger_lighttruckwithrim * 25 }}</td>
                </tr>
                @php
                    $passangerTotal = $passanger_lighttruckwithrim * 25 + $passanger_lighttruck * 15 + $lawnmowers_atvmotorcyclewithrim * 25 + $lawnmowers_atvmotorcycle * 15;
                @endphp
                <tr style="border: none;">
                    <td style="border: none;" colspan="2"></td>
                    <td style="text-align: right;">Passenger Total</td>
                    <td>{{ $passangerTotal }}</td>
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
                    <td class="blue">{{ $semi_truck }}</td>
                    <td style="text-align: right;">110</td>
                    <td> {{ $semi_truck * 110 }}</td>
                </tr>
                <tr>
                    <td>Semi super single</td>
                    <td class="blue">{{ $semi_super_singles }}</td>
                    <td style="text-align: right;" class="">110</td>
                    <td> {{ $semi_super_singles * 110 }}</td>
                </tr>
                <tr>
                    <td>Semi Truck with Rim</td>
                    <td class="blue">{{ $semi_truck_with_rim }}</td>
                    <td style="text-align: right;">125</td>
                    <td> {{ $semi_truck_with_rim * 125 }}</td>
                </tr>

                @php
                    $truckTotal = $semi_truck * 110 + $semi_truck * 110 + $semi_truck * 125;
                @endphp
                <tr style="border: none;">
                    <td style="border: none;" colspan="2"></td>
                    <td style="text-align: left;">Truck Total</td>
                    <td>{{ $truckTotal }}</td>
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
                    <td class="blue">{{ $ag_med_truck_19_5_skid_steer }}</td>
                    <td style="text-align: right;">60</td>
                    <td>{{ $ag_med_truck_19_5_skid_steer * 60 }}</td>
                </tr>
                <tr>
                    <td>AG Med Truck 19.5/ with Rim</td>
                    <td class="blue">{{ $ag_med_truck_19_5_with_rim }}</td>
                    <td style="text-align: right;" class="">60</td>
                    <td>{{ $ag_med_truck_19_5_with_rim * 60 }}</td>
                </tr>
                <tr>
                    <td>Farm Tractor $1.25 per, Last two digits</td>
                    <td class="blue">{{ $farm_tractor_last_two_digits }}</td>
                    <td style="text-align: right;">5</td>
                    <td>{{ $farm_tractor_last_two_digits * 5 }}</td>
                </tr>

                @php
                    $agriTotal = $farm_tractor_last_two_digits * 5 + $ag_med_truck_19_5_with_rim * 60 + $ag_med_truck_19_5_skid_steer * 60;
                @endphp


                <tr style="border: none;">
                    <td style="border: none;" colspan="2"></td>
                    <td style="text-align: left;">Agri Total</td>
                    <td>{{ $agriTotal }}</td>
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
                    <td class="blue">{{ $driver_15_5_24 }}</td>
                    <td style="text-align: right;">158</td>
                    <td>{{ $driver_15_5_24 * 158 }}</td>
                </tr>
                <tr>
                    <td>15.5-25(Radial)</td>
                    <td class="blue">{{ $driver_17_5_25 }}</td>
                    <td style="text-align: right;" class="">300</td>
                    <td>{{ $driver_17_5_25 * 300 }}</td>
                </tr>
                <tr>
                    <td>20.5-25(Radial)</td>
                    <td class="blue">{{ $driver_20_5_25 }}</td>
                    <td style="text-align: right;">330</td>
                    <td>{{ $driver_20_5_25 * 330 }}</td>
                </tr>

                <tr>
                    <td>23.5-25(Radial)</td>
                    <td class="blue">{{ $driver_23_5_25 }}</td>
                    <td style="text-align: right;">551</td>
                    <td>{{ $driver_23_5_25 * 551 }}</td>
                </tr>
                <tr>
                    <td>26.5-25(Radial)</td>
                    <td class="blue">{{ $driver_26_5_25 }}</td>
                    <td style="text-align: right;">1000</td>
                    <td>{{ $driver_26_5_25 * 1000 }}</td>
                </tr>
                <tr>
                    <td>29.5-25(Radial)</td>
                    <td class="blue">{{ $driver_29_5_25 }}</td>
                    <td style="text-align: right;">1279</td>
                    <td>{{ $driver_29_5_25 * 1279 }}</td>
                </tr>
                <tr>
                    <td>24.00R35</td>
                    <td class="blue">{{ $driver_24_00R35 }}</td>
                    <td style="text-align: right;">1816</td>
                    <td>{{ $driver_24_00R35 * 1816 }}</td>
                </tr>
                <tr>
                    <td>13.00-24</td>
                    <td class="blue">{{ $driver_13_00_24 }}</td>
                    <td style="text-align: right;">158</td>
                    <td>{{ $driver_13_00_24 * 158 }}</td>
                </tr>
                <tr>
                    <td>14.00-24(Radial)</td>
                    <td class="blue">{{ $driver_14_00_24 }}</td>
                    <td style="text-align: right;">293</td>
                    <td>{{ $driver_14_00_24 * 293 }}</td>
                </tr>
                <tr>
                    <td>19.5L-24</td>
                    <td class="blue">{{ $driver_19_5L_24 }}</td>
                    <td style="text-align: right;">192</td>
                    <td>{{ $driver_19_5L_24 * 192 }}</td>
                </tr>

                @php
                    $otherTotal = $driver_19_5L_24 * 192 + $driver_14_00_24 * 293 + $driver_13_00_24 * 158 + $driver_24_00R35 * 1816 + $driver_29_5_25 * 1279 + $driver_26_5_25 * 1000 + $driver_23_5_25 * 551 + $driver_20_5_25 * 330 + $driver_17_5_25 * 300 + $driver_15_5_24 * 158;
                @endphp
                {{-- <tr>
                    <td>18.4-30</td>
                    <td class="blue"></td>
                    <td style="text-align: right;">209</td>
                    <td>$ 0.00</td>
                </tr>
                <tr>
                    <td>18.4-38</td>
                    <td class="blue"></td>
                    <td style="text-align: right;">271</td>
                    <td>$ 0.00</td>
                </tr>
                <tr>
                    <td>520/80R46</td>
                    <td class="blue"></td>
                    <td style="text-align: right;">465</td>
                    <td>$ 0.00</td>
                </tr>
                <tr>
                    <td>480/80R50</td>
                    <td class="blue"></td>
                    <td style="text-align: right;">500</td>
                    <td>$ 0.00</td>
                </tr>
                <tr>
                    <td>710/70R43</td>
                    <td class="blue"></td>
                    <td style="text-align: right;">741</td>
                    <td>$ 0.00</td>
                </tr>
                <tr>
                    <td>Odd Tire/inches</td>
                    <td class="blue"></td>
                    <td style="text-align: right;">6</td>
                    <td>$ 0.00</td>
                </tr>
                <tr>
                    <td>Odd Tire/inches</td>
                    <td class="blue"></td>
                    <td style="text-align: right;">6</td>
                    <td>$ 0.00</td>
                </tr> --}}

                <tr style="border: none;">
                    <td style="border: none;" colspan="2"></td>
                    <td style="text-align: left;">Other Total</td>
                    <td>{{ $otherTotal }}</td>
                </tr>




                <tr style="border: none;">
                    <td style="border: none;" colspan="2"></td>
                    <td style="text-align: left;">Passenger Total lbs</td>
                    <td>{{ $passangerTotal }}</td>
                </tr>
                <tr style="border: none;">
                    <td style="border: none;" colspan="2"></td>
                    <td style="text-align: left;">Truck Total lbs</td>
                    <td>{{ $truckTotal }}</td>
                </tr>
                <tr style="border: none;">
                    <td style="border: none;" colspan="2"></td>
                    <td style="text-align: left;">Agri Total lbs</td>
                    <td>{{ $agriTotal }}</td>
                </tr>
                <tr style="border: none;">
                    <td style="border: none;" colspan="2"></td>
                    <td style="text-align: left;">Other Total lbs</td>
                    <td>{{$otherTotal}}</td>
                </tr>
                <tr style="border: none;">
                    <td style="border: none;" colspan="2"></td>
                    <td style="text-align: left;">Total lbs</td>
                    <td>{{$passangerTotal + $truckTotal + $agriTotal + $otherTotal}}</td>
                </tr>
            </tbody>

        </table>
    </table>

</body>

</html>
