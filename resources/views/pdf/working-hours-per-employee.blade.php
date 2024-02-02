<!DOCTYPE html>
<html>
<head>
    <title>Working Hours</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<h2>Employee List</h2>
<table>
    <thead>
    <tr>
        <th>Date</th>
        <th>Working Hours</th>
        <!-- Add more table headers for other employee attributes -->
    </tr>
    </thead>
    <tbody>
    @php
        $totalWorkingHours = 0;
    @endphp
    @foreach($workingHours as $workingHour)
        <tr>
            <td>{{ $workingHour->date }}</td>
            <td>{{ $workingHour->working_hours }}</td>
            <!-- Add more table cells for other employee attributes -->
        </tr>
        @php
            $totalWorkingHours += $workingHour->working_hours;
        @endphp
    @endforeach
    <tr>
        <td>Total</td>
        <td>{{ $totalWorkingHours }}</td>
    </tr>
    </tbody>
</table>
</body>
</html>
