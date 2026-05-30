<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Privacy Settings</title>

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

        .menu-button {
            background: #3490dc;
            color: white;
            border: none;
            padding: 10px 15px;
            font-size: 20px;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
        }

        .block-btn {
            background: #3490dc;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
        }

        .block-btn:hover {
            background: #2574a9;
        }

        .mute-btn {
            background: #3490dc;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
        }

        .mute-btn:hover {
            background: #2574a9;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div>Social Media - Privacy Settings</div>
    <div>
        <a class="menu-button" href="/dashboard">← Back to Dashboard</a>
    </div>
</div>

<div class="container">

    @if(session('success'))
        <div class="card" style="border: 1px solid #2ecc71; background: #ecf9f1; color: #155724;">
            {{ session('success') }}
        </div>
    @endif

    <div class="card" style="border-top: 3px solid #e74c3c;">
        <h3>Daftar Akun Terblokir</h3>
        
        @if($blockedUsers->isEmpty())
            <p style="color: #666; font-style: italic;">Tidak ada akun yang sedang diblokir.</p>
        @else
            <ul style="list-style: none; padding: 0;">
                @foreach($blockedUsers as $blockData)
                    <li style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #eee;">
                        <span><strong>{{ $blockData->blockedUser?->username ?? 'Unknown User' }}</strong></span>
                        <form method="POST" action="{{ route('block', $blockData->blocked_user_id) }}" onsubmit="return confirm('Yakin ingin membuka blokir akun ini?')">
                            @csrf
                            <button type="submit" class="block-btn">Unblock</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <div class="card" style="border-top: 3px solid #f39c12;">
        <h3>Daftar Akun Terbisukan</h3>

        @if($mutedUsers->isEmpty())
            <p style="color: #666; font-style: italic;">Tidak ada akun yang sedang dibisukan.</p>
        @else
            <ul style="list-style: none; padding: 0;">
                @foreach($mutedUsers as $muteData)
                    <li style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #eee;">
                        <span><strong>{{ $muteData->mutedUser?->username ?? 'Unknown User' }}</strong></span>
                        <form method="POST" action="{{ route('mute', $muteData->muted_user_id) }}" onsubmit="return confirm('Yakin ingin membunyikan kembali akun ini?')">
                            @csrf
                            <button type="submit" class="mute-btn">Unmute</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

</div>

</body>
</html>