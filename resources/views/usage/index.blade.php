<!DOCTYPE html>
<html>
<head>
    <title>Usage Statistics</title>

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
            align-items: center;
        }

        .back-btn {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .container {
            width: 900px;
            margin: 25px auto;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .stat-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            border-left: 4px solid #3490dc;
        }

        .stat-card h3 {
            margin: 0;
            color: #666;
            font-size: 14px;
        }

        .stat-card p {
            margin: 12px 0 0;
            font-size: 32px;
            font-weight: bold;
            color: #3490dc;
        }

        .usage-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .usage-info h2 {
            margin: 0;
        }

        .usage-total {
            color: #888;
            font-size: 14px;
            margin-top: 5px;
        }

        .stat-link {
            text-decoration: none;
            color: inherit;
        }

        .stat-link:hover .stat-card {
            transform: translateY(-3px);
            transition: 0.2s;
        }
    </style>
</head>
<body>

<div class="navbar">
    <a href="/dashboard" class="back-btn">← Back</a>
    <strong>Usage Statistics</strong>
    <span></span>
</div>

<div class="container">
    <div class="card">
        <div class="usage-header">
            <div class="usage-info">
                <h2>Platform Statistics</h2>
                <div class="usage-total">Summary of application usage data</div>
            </div>
        </div>
    </div>

    <div class="stats-grid">
        <a href="/usage/users" class="stat-link">
            <div class="stat-card">
                <h3>Total Users</h3>
                <p>{{ $totalUsers }}</p>
            </div>
        </a>

        <a href="/usage/tweets" class="stat-link">
            <div class="stat-card">
                <h3>Total Tweets</h3>
                <p>{{ $totalTweets }}</p>
            </div>
        </a>

        <a href="/usage/communities" class="stat-link">
            <div class="stat-card">
                <h3>Total Communities</h3>
                <p>{{ $totalCommunities }}</p>
            </div>
        </a>

        <a href="/usage/community-activities" class="stat-link">
            <div class="stat-card">
                <h3>Community Activities</h3>
                <p>{{ $communityActivities }}</p>
            </div>
        </a>

        <a href="/usage/follow-activities" class="stat-link">
            <div class="stat-card">
                <h3>Follow Activities</h3>
                <p>{{ $followActivities }}</p>
            </div>
        </a>

    </div>

</div>

</body>
</html>
