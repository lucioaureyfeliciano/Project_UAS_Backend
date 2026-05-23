<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>

    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
            margin: 0;
        }

        .navbar {
            background: #3490dc;
            padding: 15px;
            color: white;
            display: flex;
            justify-content: space-between;
        }

        .container {
            width: 600px;
            margin: 20px auto;
        }

        .card {
            background: white;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
        }

        .logout-btn {
            background: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div>Social Media</div>

    <form method="POST" action="/logout">
        @csrf
        <button class="logout-btn">Logout</button>
    </form>
</div>

<div class="container">

    <div class="card">
        <h3>Welcome, {{ auth()->user()->username }}</h3>
        <p>This is your dashboard</p>
    </div>

</div>

</body>
</html>