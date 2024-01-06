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

    <table>
        <table>
            <thead>
                <tr>
                    <th>Trailer Swap</th>
                    <th>Date ({{ $data->created_at->format('M d Y') }})</th>
                    <th>Time ({{ $data->created_at->format('H:i:s') }})</th>
                    <th>DRIVER ({{ $data->driver->name }})</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Customer Name</td>
                    <td class="">{{ $data->customer->business_name ?? '' }}</td>
                    <td class="">Customer Address</td>
                    <td> <span style="text-align: right">{{ $data->customer->address }}</span></td>

                </tr>
                <tr>
                    <td>Trailer Number Dropped</td>
                    <td class="">{{ $data->trailerSwapOrder->trailer_drop_off }}</td>
                    <td style="text-align: right;">Trailer Number Picked Up</td>
                    <td>{{ $data->trailerSwapOrder->trailer_pick_up }}</td>
                </tr>
                <tr>
                    <td>Payment Type</td>
                    <td class="">{{$data->payment_type}}</td>
                    <td style="text-align: right;">Swap Total</td>
                    <td>$ {{ number_format( $data->customerPricing->swap_total ?? 0 , 2)}}</td>
                </tr>
                <tr>
                    <td></td>
                    <td class=""></td>
                    <td style="text-align: right;">Tax</td>
                    <td>
                        {{number_format($data->customer->tax ?? 0, 2)}}
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td style="text-align: right;">After Tax Value</td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td style="text-align: right;">Convenience Fee</td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td style="text-align: right;">Total Due</td>
                    <td></td>
                </tr>

            </tbody>
        </table>



    </table>

</body>

</html>
