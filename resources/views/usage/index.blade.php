<!DOCTYPE html>
<html>
<head>
    <title>Usage Statistics</title>
</head>
<body>

<a href="/dashboard">← Back to Dashboard</a>

<h1>Usage Statistics</h1>

<ul>
    <li>Total Users: {{ $totalUsers }}</li>
    <li>Total Tweets: {{ $totalTweets }}</li>
    <li>Total Communities: {{ $totalCommunities }}</li>
    <li>Public Communities: {{ $publicCommunities }}</li>
    <li>Private Communities: {{ $privateCommunities }}</li>
    <li>Total Community Memberships: {{ $totalMemberships }}</li>
</ul>

</body>
</html>