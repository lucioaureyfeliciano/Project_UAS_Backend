<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mute;

class MuteController extends Controller
{
    public function toggle($muted_user_id)
    {
        $user_id = auth()->id();

        if ($user_id == $muted_user_id) {
            return back()->with('error', 'Tidak bisa membisukan akun anda sendiri.');
        }

        $mute = Mute::where('user_id', $user_id)
            ->where('muted_user_id', $muted_user_id)
            ->first();

        if ($mute) {
            $mute->delete(); 
            $message = 'Akun berhasil dibunyikan kembali.';
        } else {
            Mute::create([ 
                'user_id' => $user_id,
                'muted_user_id' => $muted_user_id
            ]);
            $message = 'Akun berhasil dibisukan.';
        }

        return back()->with('success', $message);
    }
}
