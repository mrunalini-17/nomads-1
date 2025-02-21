<!DOCTYPE html>
<html>
<head>
    <title>User List</title>
    <style>
        /* body { font-family: Arial, sans-serif; } */
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Enquiry Report</h1>
    <p>Date: {{ $date }}</p>
    <p>Name of employee: </p>
    <p>From: </p>
    <p>To:</p>
    <p>Total Count: </p>

    <table>
        <thead>
            <tr>
                <th>S.No</th>
                <th>Name</th>
                <th>Services</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user['name'] }}</td>
                    <td>{{ $user['email'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
