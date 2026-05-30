<?php

namespace App\Http\Controllers;

use App\Models\Community;
use Illuminate\Http\Request;

class CommunityController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');

        $communities = Community::with('creator', 'members')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%')
                             ->orWhere('description', 'like', '%' . $search . '%');
            })
            ->latest()
            ->get();

        return view('community.index', compact('communities', 'search'));
    }

    public function show($id)
    {
        $community = Community::with('creator', 'members')->findOrFail($id);

        return view('community.show', compact('community'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:communities,name',
            'description' => 'required|string',
            'is_private' => 'boolean',
        ]);

        $community = Community::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'is_private' => $request->input('is_private', false),
            'user_id' => auth()->id(),
        ]);

        $community->members()->attach(auth()->id());

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Community created successfully',
                'community' => $community,
            ], 201);
        }

        return redirect('/community')->with('success', 'Community created successfully');
    }

    public function join($id)
    {
        $community = Community::findOrFail($id);

        if ($community->is_private) {
            return redirect()->back()
                ->with('error', 'Private community cannot be joined directly');
        }
        
        if ($community->members()->where('user_id', auth()->id())->exists()) {
            return redirect()->back()->with('error', 'Already a member');
        }

        $community->members()->attach(auth()->id());

        return redirect()->back()->with('success', 'Successfully joined community');
    }

    public function leave($id)
    {
        $community = Community::findOrFail($id);

        if ($community->user_id === auth()->id()) {
            return redirect()->back()->with('error', 'Creator cannot leave the community');
        }

        $community->members()->detach(auth()->id());

        return redirect()->back()->with('success', 'Successfully left community');
    }

    public function edit(Request $request, $id)
    {
        $community = Community::findOrFail($id);

        if ($community->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $request->validate([
            'name' => 'sometimes|string|max:255|unique:communities,name,' . $id,
            'description' => 'sometimes|string',
            'is_private' => 'nullable|boolean',
        ]);

        $community->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'is_private' => $request->has('is_private'),
        ]);

        return redirect('/community/' . $community->id)->with('success', 'Community updated successfully');
    }

    public function destroy($id)
    {
        $community = Community::findOrFail($id);

        if ($community->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        $community->delete();

        return redirect('/community')->with('success', 'Community deleted successfully');
    }
}
