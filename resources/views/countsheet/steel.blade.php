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
                    <th>Steel</th>
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
                    <td>Start Weight</td>
                    <td class="">{{ $data->steel->start_weight }}</td>
                    <td style="text-align: right;">End Weight</td>
                    <td>{{ $data->steel->end_weight }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td class=""></td>
                    <td style="text-align: right;">Per Metric Ton</td>
                    <td class="">{{ $data->customerPricing->per_metric_ton }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td class=""></td>
                    <td style="text-align: right;">Total Weight Metric Tons</td>
                    // need to change to postive number
                    <td>{{ number_format(abs(($data->steel->end_weight - $data->steel->start_weight) / 2240), 2) }}</td>
                </tr>
                <tr>
                    <td>Bol #</td>
                    <td class="">{{ $data->steel->bol }}</td>
                    <td style="text-align: right;">Total</td>
                    <td>
                        {{ number_format((($data->steel->end_weight - $data->steel->start_weight) / 2240) *$data->customerPricing->per_metric_ton ?? 0, 2) }}
                    </td>
                </tr>
                <tr>
                    <td>P.O. Number</td>
                    <td>{{ $data->customer->po ?? 'N/A' }}</td>
                    <td></td>
                    <td></td>
                </tr>


            </tbody>
        </table>



    </table>

</body>

</html>
