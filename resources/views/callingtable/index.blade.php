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

            <a href="{{ route('calling.table.create') }}" style="text-align: right;margin-bottom:20px">Add Data</a> <br>
            <br>
            <a href="{{ url('/home') }}" style="margin-top:80px" class="">Go Back</a>

            <p style="margin-bottom: 10px; margin-top: 30px">Week {{ $week }}</p>
            <form action="{{ route('calling.table.index') }}" method="GET" id="weekForm">
                @csrf
                <select name="week" id="weekSelect'" class="form-control" style="margin-bottom: 20px">
                    <option value="1" {{ $week == '1' ? 'selected' : '' }}>1</option>
                    <option value="2" {{ $week == '2' ? 'selected' : '' }}>2</option>
                    <option value="3" {{ $week == '3' ? 'selected' : '' }}>3</option>
                    <option value="4" {{ $week == '4' ? 'selected' : '' }}>4</option>
                </select>
                <button type="submit">Submit</button>
            </form>
            <table>
                <thead>
                    <tr>
                        <th>Truck#</th>
                        <th>Monday</th>
                        <th>Tuesday</th>
                        <th>Wednesday</th>
                        <th>Thursday</th>
                        <th>Friday</th>
                    </tr>
                </thead>
                <tbody>

                    @if (!empty($callingTable))
                        @foreach ($callingTable as $truckId => $days)
                            <tr>
                                @php
                                    $truck = \App\Models\Truck::find($truckId);
                                @endphp
                                <td>{{ $truck->name }}</td>

                                <td>
                                    @php
                                        $mondayCustomers = [];
                                    @endphp
                                    @if (isset($days['MONDAY']))
                                        @foreach ($days['MONDAY'] as $record)
                                            @php
                                                $mondayCustomersData = explode(',', $record['customer_ids']);
                                                foreach ($mondayCustomersData as $customerId) {
                                                    $customerData = \App\Models\Customer::find($customerId);
                                                    $mondayCustomers[] = [
                                                        'id' => $customerId,
                                                        'business_name' => $customerData['business_name'],
                                                        'color' => $customerData->color ?? '#000000',
                                                        'calling_id' => $record['id'], // Replace 'attribute_name' with the actual attribute name
                                                    ];
                                                }
                                            @endphp
                                        @endforeach
                                        @foreach ($mondayCustomers as $customer)
                                            <a style="color: {{ $customer['color'] }}"
                                                href="{{ route('order.create', ['customerId' => $customer['id']]) }}">{{ $customer['business_name'] }}</a>
                                            <a href="{{ route('calling.table.delete', ['id' => $customer['calling_id'], 'customer_id' => $customer['id']]) }}"
                                                style="color: red">X</a>
                                            <br><br>
                                        @endforeach
                                    @endif
                                </td>

                                <td>
                                    @php
                                        $tuesdayCustomers = [];
                                    @endphp
                                    @if (isset($days['TUESDAY']))
                                        @foreach ($days['TUESDAY'] as $record)
                                            @php
                                                $tuesdayCustomersData = explode(',', $record['customer_ids']);
                                                foreach ($tuesdayCustomersData as $customerId) {
                                                    $customerData = \App\Models\Customer::find($customerId);
                                                    $tuesdayCustomers[] = [
                                                        'id' => $customerId,
                                                        'business_name' => $customerData['business_name'],
                                                        'color' => $customerData->color ?? '#000000',
                                                        'calling_id' => $record['id'], // Replace 'attribute_name' with the actual attribute name
                                                    ];
                                                }
                                            @endphp
                                        @endforeach
                                        @foreach ($tuesdayCustomers as $customer)
                                            <a style="color: {{ $customer['color'] }}"
                                                href="{{ route('order.create', ['customerId' => $customer['id']]) }}">{{ $customer['business_name'] }}</a>
                                            <a href="{{ route('calling.table.delete', ['id' => $customer['calling_id'], 'customer_id' => $customer['id']]) }}"
                                                style="color: red">X</a>
                                            <br><br>
                                        @endforeach
                                    @endif
                                </td>

                                <td>
                                    @php
                                        $wednesdayCustomers = [];
                                    @endphp
                                    @if (isset($days['WEDNESDAY']))
                                        @foreach ($days['WEDNESDAY'] as $record)
                                            @php
                                                $wednesdayCustomersData = explode(',', $record['customer_ids']);
                                                foreach ($wednesdayCustomersData as $customerId) {
                                                    $customerData = \App\Models\Customer::find($customerId);
                                                    $wednesdayCustomers[] = [
                                                        'id' => $customerId,
                                                        'business_name' => $customerData['business_name'],
                                                        'color' => $customerData->color ?? '#000000',
                                                        'calling_id' => $record['id'], // Replace 'attribute_name' with the actual attribute name
                                                    ];
                                                }
                                            @endphp
                                        @endforeach
                                        @foreach ($wednesdayCustomers as $customer)
                                            <a style="color: {{ $customer['color'] }}"
                                                href="{{ route('order.create', ['customerId' => $customer['id']]) }}">{{ $customer['business_name'] }}</a>
                                            <a href="{{ route('calling.table.delete', ['id' => $customer['calling_id'], 'customer_id' => $customer['id']]) }}"
                                                style="color: red">X</a>
                                            <br><br>
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $thursdayCustomers = [];
                                    @endphp
                                    @if (isset($days['THURSDAY']))
                                        @foreach ($days['THURSDAY'] as $record)
                                            @php
                                                $thursdayCustomersData = explode(',', $record['customer_ids']);
                                                foreach ($thursdayCustomersData as $customerId) {
                                                    $customerData = \App\Models\Customer::find($customerId);
                                                    $thursdayCustomers[] = [
                                                        'id' => $customerId,
                                                        'business_name' => $customerData['business_name'],
                                                        'color' => $customerData->color ?? '#000000',
                                                        'calling_id' => $record['id'], // Replace 'attribute_name' with the actual attribute name
                                                    ];
                                                }
                                            @endphp
                                        @endforeach
                                        @foreach ($thursdayCustomersData as $customer)
                                            <a style="color: {{ $customer['color'] }}"
                                                href="{{ route('order.create', ['customerId' => $customer['id']]) }}">{{ $customer['business_name'] }}</a>
                                            <a href="{{ route('calling.table.delete', ['id' => $customer['calling_id'], 'customer_id' => $customer['id']]) }}"
                                                style="color: red">X</a>
                                            <br><br>
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $fridayCustomers = [];
                                    @endphp
                                    @if (isset($days['FRIDAY']))
                                        @foreach ($days['FRIDAY'] as $record)
                                            @php
                                                $fridayCustomersData = explode(',', $record['customer_ids']);
                                                foreach ($fridayCustomersData as $customerId) {
                                                    $customerData = \App\Models\Customer::find($customerId);
                                                    $fridayCustomers[] = [
                                                        'id' => $customerId,
                                                        'business_name' => $customerData['business_name'],
                                                        'color' => $customerData->color ?? '#000000',
                                                        'calling_id' => $record['id'], // Replace 'attribute_name' with the actual attribute name
                                                    ];
                                                }
                                            @endphp
                                        @endforeach
                                        @foreach ($fridayCustomers as $customer)
                                            <a style="color: {{ $customer['color'] }}"
                                                href="{{ route('order.create', ['customerId' => $customer['id']]) }}">{{ $customer['business_name'] }}</a>
                                            <a href="{{ route('calling.table.delete', ['id' => $customer['calling_id'], 'customer_id' => $customer['id']]) }}"
                                                style="color: red">X</a>
                                            <br><br>
                                        @endforeach
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif



                    <!-- Add your table data here -->
                </tbody>
            </table>
    </div>

</body>

</html>
