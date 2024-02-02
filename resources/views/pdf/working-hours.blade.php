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
<h2>Working hours of employees</h2>
<table>
    <thead>
    <tr>
        <th>Employee</th>
        <th>Working Hours</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->total_working_hours_for_month }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
