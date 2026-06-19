<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Block;

class BlockController extends Controller
{
    public function toggle($blocked_user_id)
    {
        $user_id = auth()->id();

        if ($user_id == $blocked_user_id) {
            return back()->with('error', 'Tidak bisa memblokir akun anda sendiri.');
        }

        $block = Block::where('user_id', $user_id)
            ->where('blocked_user_id', $blocked_user_id)
            ->first();

        if ($block) {
            $block->delete();
            $message = 'User berhasil dihapus dari daftar blokir.';
        } else {
            Block::create([
                'user_id'=>$user_id,
                'blocked_user_id'=>$blocked_user_id
            ]);
            $message = 'User berhasil diblokir.';
        }
        return back()->with('success', $message);
    }
}
