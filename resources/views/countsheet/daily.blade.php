<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
        * {
            box-sizing: border-box;
            padding: 0px;
            margin: 0px;
            font-family: Arial, Helvetica, sans-serif;
        }

        .body {
            margin: 40px;
            background-color: #f3f3f3;
            padding: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000000;
            text-align: left;
            padding: 8px;
        }

        .pink {
            background-color: #ff4ce4;
        }

        .red {
            color: red;
        }

        .white {
            color: transparent;
        }

        .blue {
            background-color: #069de7;
            text-align: center;
        }

        th:nth-child(2),
        td:nth-child(2) {
            width: 300px;
        }
    </style>
</head>

<body>

    <div class="body">
        <h4 style="text-align: center">RELIABLE TIRE DISPOSAL DAILY COUNT SHEET</h4>
        <h4 style="text-align: center">3345 E State Hwy 29 Burrnet , TX 78611</>
            <h4 style="text-align: center">512-762-8219</h4>

            <div class="float-right">
                <form action="{{ route('generate.daily.count.sheet') }}">
                    <input type="date" class="form-control" name="date">
                    <button class="btn btn-primary" type="submit">Fetch</button>
                </form>

            </div>
            <a href="{{url('/home')}}" style="margin-top:30px" class="">Go Back</a>

            <p style="margin-bottom: 10px; margin-top: 30px">{{ now()->format('D, M d Y') }}</p>
            <table>
                <thead>
                    <tr>
                        <th>Truck</th>
                        <th>Generator ()</th>
                        <th>Passenger/LT</th>
                        <th>Semi</th>
                        <th>AG</th>
                        <th>Tractor</th>
                        <th>MC/ATV</th>
                        <th>Total</th>
                        <th class="pink">Resale</th>
                        <th>Cemex</th>
                        <th>Rims</th>
                        <th>Inhouse Shreddings</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalPassanger = 0;
                        $lastSemi = 0;
                        $lastAG = 0;
                        $lastTractor = 0;
                        $lastMCATV = 0;
                        $lastTotal = 0;
                        $lastResale = 0;
                        $lastTotalRims = 0;
                        $lastShredding = 0;
                    @endphp
                    @foreach ($todaysOrders as $key => $groupOrder)
                        @php
                            $sumOfRims = 0;
                            $assignedTruck;
                            $assignedTruck = \App\Models\TruckDriver::where('user_id', $key)->first();
                            if ($assignedTruck) {
                                $assignedTruck = \App\Models\Truck::find($assignedTruck->truck_id);
                            }
                        @endphp

                        <!-- first -->
                        @foreach ($groupOrder as $key2 => $order)
                            @php
                                $keyssss = $order['load_type'] == 'trailer_swap' ? 'compared' : 'fulfilled';
                                $typesOfPassangerTires = !empty($order[$keyssss]['type_of_passenger'])
                                    ? json_decode($order[$keyssss]['type_of_passenger'], true)
                                    : [];
                                $typesOfTruckTires = !empty($order[$keyssss]['type_of_truck_tyre'])
                                    ? json_decode($order[$keyssss]['type_of_truck_tyre'], true)
                                    : [];
                                $typesOfAgriTires = !empty($order[$keyssss]['type_of_agri_tyre'])
                                    ? json_decode($order[$keyssss]['type_of_agri_tyre'], true)
                                    : [];
                                $typesOfOtherTires = !empty($order[$keyssss]['type_of_other'])
                                    ? json_decode($order[$keyssss]['type_of_other'], true)
                                    : [];

                                //for single passanger
                                $lawnmowers_atvmotorcycle = 0;
                                $lawnmowers_atvmotorcyclewithrim = 0;
                                $passanger_lighttruck = 0;
                                $passanger_lighttruckwithrim = 0;
                                $passangersTotalTires = 0;
                                foreach ($typesOfPassangerTires as $item) {
                                    foreach ($item as $key => $value) {
                                        if ($key == 'lawnmowers_atvmotorcycle') {
                                            $lawnmowers_atvmotorcycle = $value;
                                        } elseif ($key == 'lawnmowers_atvmotorcyclewithrim') {
                                            $lawnmowers_atvmotorcyclewithrim = $value;
                                        } elseif ($key == 'passanger_lighttruck') {
                                            $passangersTotalTires += $value;
                                            $passanger_lighttruck = $value;
                                        } elseif ($key == 'passanger_lighttruckwithrim') {
                                            $passangersTotalTires += $value;
                                            $passanger_lighttruckwithrim = $value;
                                        }
                                    }
                                }
                                $sumOfRims += $passanger_lighttruckwithrim + $lawnmowers_atvmotorcyclewithrim;

                                //for single truck
                                $semi_truck = 0;
                                $semi_super_singles = 0;
                                $semi_truck_with_rim = 0;
                                $semiTotalTires = 0;
                                foreach ($typesOfTruckTires as $item) {
                                    foreach ($item as $key => $value) {
                                        $semiTotalTires += $value;
                                        if ($key == 'semi_truck') {
                                            $semi_truck = $value;
                                        } elseif ($key == 'semi_super_singles') {
                                            $semi_super_singles = $value;
                                        } elseif ($key == 'semi_truck_with_rim') {
                                            $semi_truck_with_rim = $value;
                                        }
                                    }
                                }

                                $sumOfRims += $semi_truck_with_rim;

                                // for single agri

                                $ag_med_truck_19_5_skid_steer = 0;
                                $ag_med_truck_19_5_with_rim = 0;
                                $farm_tractor_last_two_digits = 0;

                                $agriTotalTires = 0;
                                $tractor = 0;

                                foreach ($typesOfAgriTires as $item) {
                                    foreach ($item as $key => $value) {
                                        $agriTotalTires += $value;

                                        if ($key == 'ag_med_truck_19_5_skid_steer') {
                                            $ag_med_truck_19_5_skid_steer = $value;
                                        } elseif ($key == 'ag_med_truck_19_5_with_rim') {
                                            $ag_med_truck_19_5_with_rim = $value;
                                        } elseif ($key == 'farm_tractor_last_two_digits') {
                                            $tractor += $value;
                                        }
                                    }
                                }

                                $sumOfRims += $ag_med_truck_19_5_with_rim;

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
                                $otherTotal = 0;

                                foreach ($typesOfOtherTires as $item) {
                                    foreach ($item as $key => $value) {
                                        $otherTotal += $value;
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

                                $typesOfReusePassangerTires = !empty($order['compared']['reuse_type_of_passenger'])
                                    ? json_decode($order['compared']['reuse_type_of_passenger'], true)
                                    : [];
                                $typesOfReuseAgriTires = !empty($order['compared']['reuse_type_of_agri_tyre'])
                                    ? json_decode($order['compared']['reuse_type_of_agri_tyre'], true)
                                    : [];
                                $typesOfReuseTruckTires = !empty($order['compared']['reuse_type_of_truck_tyre'])
                                    ? json_decode($order['compared']['reuse_type_of_truck_tyre'], true)
                                    : [];
                                $typesOfReuseOtherTires = !empty($order['compared']['reuse_type_of_other'])
                                    ? json_decode($order['compared']['reuse_type_of_other'], true)
                                    : [];

                                $totalSumReusePassangerTires = collect($typesOfReusePassangerTires)
                                    ->flatMap(function ($item) {
                                        return $item;
                                    })
                                    ->sum();

                                $totalSumReuseAgriTires = collect($typesOfReuseAgriTires)
                                    ->flatMap(function ($item) {
                                        return $item;
                                    })
                                    ->sum();

                                $totalSumReuseTruckTires = collect($typesOfReuseTruckTires)
                                    ->flatMap(function ($item) {
                                        return $item;
                                    })
                                    ->sum();

                                $totalSumReuseOtherTires = collect($typesOfReuseOtherTires)
                                    ->flatMap(function ($item) {
                                        return $item;
                                    })
                                    ->sum();

                                $totalReuse =
                                    $totalSumReusePassangerTires +
                                    $totalSumReuseAgriTires +
                                    $totalSumReuseTruckTires +
                                    $totalSumReuseOtherTires;

                            @endphp
                            <tr>
                                <td class="red">{{ $key2 == 0 ? $assignedTruck->name ?? '' : '' }}</td>
                                <td class="red">{{ $order['customer']['business_name'] }}</td>
                                @php
                                    $totalPassanger += $passangersTotalTires;
                                    $lastSemi += $semiTotalTires;
                                    $lastAG += $agriTotalTires;
                                    $lastTractor += $tractor;
                                    $lastMCATV += $lawnmowers_atvmotorcyclewithrim + $lawnmowers_atvmotorcycle;
                                    $lastTotal += $passangersTotalTires + $semiTotalTires + $agriTotalTires + $tractor;
                                    $lastResale += $totalReuse;
                                    $lastTotalRims += $sumOfRims;
                                    $lastShredding +=
                                        abs($passangersTotalTires + $semiTotalTires + $agriTotalTires + $tractor) -
                                        $totalReuse -
                                        $sumOfRims;
                                @endphp
                                <td>{{ $passangersTotalTires }}</td>
                                <td>{{ $semiTotalTires }}</td>
                                <td> {{ $agriTotalTires }}</td>
                                <td> {{ $tractor }}</td>
                                <td>{{ $lawnmowers_atvmotorcyclewithrim + $lawnmowers_atvmotorcycle }}</td>
                                <td>{{ $passangersTotalTires + $semiTotalTires + $agriTotalTires + $tractor }}</td>
                                <td class="pink">{{ $totalReuse }}</td>
                                <td>*</td>
                                <td>{{ $sumOfRims }}</td>
                                <td>{{ abs($passangersTotalTires + $semiTotalTires + $agriTotalTires + $tractor) - $totalReuse - $sumOfRims }}
                                </td>
                                <td>{{ $passangersTotalTires + $semiTotalTires + $agriTotalTires + $tractor }}</td>
                            </tr>
                        @endforeach
                    @endforeach

                    <!-- last -->
                    <tr>
                        <td></td>
                        <td class="blue">Daily Tools</td>
                        <td class="blue">{{ $totalPassanger }}</td>
                        <td class="blue">{{ $lastSemi }}</td>
                        <td class="blue">{{ $lastAG }}</td>
                        <td class="blue">{{ $lastTractor }}</td>
                        <td class="blue">{{ $lastMCATV }}</td>
                        <td class="blue">{{ $lastTotal }}</td>
                        <td class="blue">{{ $lastResale }}</td>
                        <td class="blue">*</td>
                        <td class="blue">{{ $lastTotalRims }}</td>
                        <td class="blue">{{ $lastShredding }}</td>
                        <td class="blue">{{ $lastTotal }}</td>
                    </tr>
                    <!-- Add your table data here -->
                </tbody>
            </table>
    </div>
</body>

</html>
