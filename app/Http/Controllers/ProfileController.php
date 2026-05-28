<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tweet;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $tweets = Tweet::with('likes', 'reposts')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('profile', compact('user', 'tweets'));
    }

    public function updateDescription(Request $request)
    {
        $user = auth()->user();

        $user->description = $request->description;

        $user->save();

        return back()->with('success', 'Description updated successfully');
    }
}