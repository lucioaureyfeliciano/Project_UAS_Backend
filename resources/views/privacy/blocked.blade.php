<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blocked Users</title>

    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
            margin: 0;
        }

        .navbar {
            background: #3490dc;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .container {
            width: 75%;
            max-width: 900px;
            margin: 35px auto;
        }

        .card {
            background: white;
            border-radius: 18px;
            padding: 22px;
            border: 1px solid #ddd;
            box-sizing: border-box;
            width: 100%;
        }

        .back-btn {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .back-btn:hover {
            text-decoration: underline;
        }

        .action-btn {
            background: #fff;
            border: 1px solid #ddd;
            padding: 6px 16px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 13px;
            font-weight: bold;
            color: #e74c3c;
            transition: 0.2s;
        }

        .action-btn:hover {
            background: #ffe5e5;
            border-color: #ff6b6b;
            transform: scale(1.02);
        }

        .list-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
        }

        .list-item:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div>
        Daftar Akun Terblokir
    </div>
    <a href="/privacy" class="back-btn">
        ← Back to Privacy
    </a>
</div>

<div class="container">

    <div class="card" style="border-top: 4px solid #e74c3c;">
        
        @forelse($blockedUsers as $blockData)
            <div class="list-item">
                <span><strong>{{ $blockData->blockedUser?->username ?? 'Unknown User' }}</strong></span>
                
                <form method="POST" action="{{ route('block', $blockData->blocked_user_id) }}" onsubmit="return confirm('Yakin ingin membuka blokir akun ini?')">
                    @csrf
                    <button type="submit" class="action-btn">
                        Unblock
                    </button>
                </form>
            </div>
        @empty
            <p style="color: #666; font-style: italic; text-align: center; margin: 20px 0;">
                Tidak ada akun yang sedang diblokir.
            </p>
        @endforelse

    </div>

</div>

</body>
</html>