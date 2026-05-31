<!DOCTYPE html>
<html>
<head>
    <title>Usage Statistics</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 900px;
            margin: auto;
        }

        .top-link {
            display: inline-block;
            margin-bottom: 18px;
            color: #3490dc;
            text-decoration: none;
        }

        .header-card {
            background: white;
            padding: 20px;
            margin-bottom: 16px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            text-align: center;
        }

        .stat-card h3 {
            margin: 0;
            color: #666;
            font-size: 15px;
        }

        .stat-card p {
            font-size: 32px;
            font-weight: bold;
            margin: 12px 0 0;
            color: #3490dc;
        }
    </style>
</head>
<body>

<div class="container">

    <a href="/dashboard" class="top-link">Back to Dashboard</a>

    <div class="header-card">
        <h1>Usage Statistics</h1>

        <p>Summary of application usage data.</p>

        <small style="color: #666;">
            Last Updated:
            {{ $lastUpdated->format('d M Y H:i') }}
        </small>
    </div>

    <div class="stats-grid">

        <div class="stat-card">
            <h3>Total Users</h3>
            <p>{{ $totalUsers }}</p>
        </div>

        <div class="stat-card">
            <h3>Total Tweets</h3>
            <p>{{ $totalTweets }}</p>
        </div>

        <div class="stat-card">
            <h3>Total Communities</h3>
            <p>{{ $totalCommunities }}</p>
        </div>

        <div class="stat-card">
            <h3>Total Memberships</h3>
            <p>{{ $totalMemberships }}</p>
        </div>

    </div>

</div>

</body>
</html>