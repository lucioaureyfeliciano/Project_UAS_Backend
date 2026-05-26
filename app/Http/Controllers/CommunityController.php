<?php

namespace App\Http\Controllers;

use App\Models\Community;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    public function index()
    {
        $communities = Community::with('user')->latest()->get();

        return view('community.index', compact('communities'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required'
        ]);

        $community = new Community();

        $community->name = $request->name;
        $community->description = $request->description;
        $community->user_id = auth()->id();

        $community->save();

        return redirect('/community');
    }
}