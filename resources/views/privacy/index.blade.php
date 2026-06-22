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

        /* Lebar container disesuaikan agar sama persis dengan profile & dashboard */
        .container {
            width: 75%;
            max-width: 900px;
            margin: 35px auto;
        }

        /* KARTU DIUBAH: Membulat lebar (18px), padding (22px), dan border tipis khas profile/tweet card */
        .card {
            background: white;
            padding: 22px;
            margin-bottom: 20px;
            border-radius: 18px;
            border: 1px solid #ddd;
            box-sizing: border-box;
            width: 100%;
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

        /* TOMBOL AKSI: Dibuat membulat elips khas tombol aplikasi kamu */
        .block-btn {
            background: #3490dc;
            color: white;
            border: none;
            padding: 6px 16px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 13px;
            font-weight: bold;
        }

        .block-btn:hover {
            background: #2574a9;
        }

        .mute-btn {
            background: #3490dc;
            color: white;
            border: none;
            padding: 6px 16px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 13px;
            font-weight: bold;
        }

        .mute-btn:hover {
            background: #2574a9;
        }

        /* GAYA BARU UNTUK BUTTON TOGGLE PRIVACY: Dibuat rounded pill lonjong biar matching */
        .privacy-toggle-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 22px;
            color: white;
            border: none;
            border-radius: 20px; /* Bikin bulat pil kyk tombol follow */
            cursor: pointer;
            font-weight: bold;
            font-size: 14px;
            transition: 0.2s;
        }

        .privacy-toggle-btn:hover {
            transform: scale(1.03);
        }

        .privacy-icon {
            width: 18px;
            height: 18px;
            object-fit: contain;
        }
    </style>
</head>
<body>
@include('components.toast')

<div class="navbar">
    <div>Social Media - Privacy Settings</div>
    <div>
        <a class="menu-button" href="/dashboard">← Back to Dashboard</a>
    </div>
</div>

<div class="container">

    {{-- KOTAK PRIVASI --}}
    <div class="card" style="border-top: 4px solid #3490dc;">
        <h3>Pengaturan Privasi Akun</h3>
        
        <form method="POST" action="{{ route('privacy.toggle') }}" style="margin-top: 15px;">
            @csrf
            
            @if(auth()->user()->is_private == 1)
                <button type="submit" class="privacy-toggle-btn" style="background-color: #4d5661;">
                    <img src="{{ asset('image/lock.png') }}" 
                        alt="Private"
                        class="privacy-icon"> 
                    PRIVATE (Klik untuk Ubah ke Public)
                </button>
            @else
                <button type="submit" class="privacy-toggle-btn" style="background-color: #3498db;">
                    <img src="{{ asset('image/unlock.png') }}" 
                        alt="Public"
                        class="privacy-icon"> 
                    PUBLIC (Klik untuk Ubah ke Private)
                </button>
            @endif
        </form>
    </div>

    {{-- KOTAK DAFTAR BLOKIR --}}
    <div class="card" style="border-top: 4px solid #e74c3c;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h3 style="margin: 0;">Daftar Akun Terblokir</h3>
                <p style="color: #666; font-size: 14px; margin: 5px 0 0 0;">Kelola akun-akun yang telah kamu blokir.</p>
            </div>
            <div style="text-align: right; display: flex; align-items: center; gap: 15px;">
                <span style="font-size: 18px; font-weight: bold; color: #e74c3c;">{{ $blockedUsers->count() }} akun</span>
                <a href="{{ route('privacy.blocked') }}" class="block-btn" style="text-decoration: none; text-align: center;">Lihat Daftar Akun</a>
            </div>
        </div>
    </div>

    {{-- KOTAK DAFTAR MUTED --}}
    <div class="card" style="border-top: 4px solid #f39c12;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h3 style="margin: 0;">Daftar Akun Terbisukan</h3>
                <p style="color: #666; font-size: 14px; margin: 5px 0 0 0;">Kelola akun-akun yang telah kamu bisukan.</p>
            </div>
            <div style="text-align: right; display: flex; align-items: center; gap: 15px;">
                <span style="font-size: 18px; font-weight: bold; color: #f39c12;">{{ $mutedUsers->count() }} akun</span>
                <a href="{{ route('privacy.muted') }}" class="mute-btn" style="text-decoration: none; text-align: center;">Lihat Daftar Akun</a>
            </div>
        </div>
    </div>

</div>

</body>
</html>
