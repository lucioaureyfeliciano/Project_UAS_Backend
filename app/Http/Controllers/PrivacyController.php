<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Block;
use App\Models\Mute;

class PrivacyController extends Controller
{
    public function show_privacy()
    {
        $user_id = auth()->id();
        $blockedUsers = Block::where('user_id', $user_id)
            ->with('blockedUser')
            ->get();

        $mutedUsers = Mute::where('user_id', $user_id)
            ->with('mutedUser')
            ->get();

        return view('privacy.index', compact('blockedUsers', 'mutedUsers'));
    }

    public function togglePrivacy(Request $request)
    {
        $user = auth()->user();

        if ($user->is_private == 1) {
            $user->is_private = 0;
            $message = 'Akun berhasil diubah menjadi publik.';
        } else {
            $user->is_private = 1;
            $message = 'Akun berhasil digembok.';
        }

        $user->save();

        return back()->with('success', $message);
    }

    public function blocked_list()
    {
        $blockedUsers = Block::where('user_id', auth()->id())->with('blockedUser')->get();
        return view('privacy.blocked', compact('blockedUsers'));
    }

    public function muted_list()
    {
        $mutedUsers = Mute::where('user_id', auth()->id())->with('mutedUser')->get();
        return view('privacy.muted', compact('mutedUsers'));
    }
}
