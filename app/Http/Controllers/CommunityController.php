<?php

namespace App\Http\Controllers;

use App\Models\Community;
use Illuminate\Http\Request;

class CommunityController extends Controller
{

    public function index()
    {
        $communities = Community::with('creator')->latest()->get();

        return view('community.index', compact('communities'));
    }

    public function show($id)
    {
        $community = Community::with('creator', 'members')->findOrFail($id);

        return view('community.show', compact('community'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:communities,name',
            'description' => 'required|string',
            'is_private'  => 'boolean',
        ]);

        $community = Community::create([
            'name'        => $request->input('name'),
            'description' => $request->input('description'),
            'is_private'  => $request->input('is_private', false),
            'user_id'     => auth()->id(),
        ]);

        $community->members()->attach(auth()->id());

        if ($request->wantsJson()) {
            return response()->json([
                'message'   => 'Community created successfully',
                'community' => $community,
            ], 201);
        }

        return redirect('/community')->with('success', 'Community created successfully');
    }

    public function join($id)
    {
        $community = Community::findOrFail($id);

        if ($community->members()->where('user_id', auth()->id())->exists()) {
            return response()->json(['message' => 'Already a member'], 409);
        }

        $community->members()->attach(auth()->id());

        return response()->json(['message' => 'Successfully joined community']);
    }

    public function leave($id)
    {
        $community = Community::findOrFail($id);

        if ($community->user_id === auth()->id()) {
            return response()->json([
                'message' => 'Creator cannot leave the community'
            ], 403);
        }

        $community->members()->detach(auth()->id());

        return response()->json(['message' => 'Successfully left community']);
    }

    public function edit(Request $request, $id)
    {
        $community = Community::findOrFail($id);

        if ($community->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'name'        => 'sometimes|string|max:255|unique:communities,name,' . $id,
            'description' => 'sometimes|string',
            'is_private'  => 'sometimes|boolean',
        ]);

        $community->update($request->only(['name', 'description', 'is_private']));

        return response()->json([
            'message'   => 'Community updated successfully',
            'community' => $community,
        ]);
    }

    public function destroy($id)
    {
        $community = Community::findOrFail($id);

        if ($community->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $community->delete();

        return response()->json(['message' => 'Community deleted successfully']);
    }
}
