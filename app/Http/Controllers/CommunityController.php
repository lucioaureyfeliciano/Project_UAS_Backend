<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\CommunityActivity;
use App\Models\CommunityJoinRequest;
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

        if ($community->is_private && 
            $community->user_id !== auth()->id() && 
            !$community->members()->where('user_id', auth()->id())->exists())
        {
            return redirect('/community')->with(
                'error',
                'This is a private community. Please send a join request.'
            );
        }

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

        CommunityActivity::create([
            'community_id' => $community->id,
            'user_id' => auth()->id(),
            'action' => 'created',
            'description' => auth()->user()->username . ' created community ' . $community->name,
        ]);

        return redirect('/community')->with('success', 'Community created successfully');
    }

    public function join($id)
    {
        $community = Community::findOrFail($id);

        if ($community->is_private) {
            return redirect()->back()->with('error', 'Private community cannot be joined directly. Please send a join request.');
        }

        if ($community->members()->where('user_id', auth()->id())->exists()) {
            return redirect()->back()->with('error', 'You are already a member of this community.');
        }

        $community->members()->attach(auth()->id());

        CommunityActivity::create([
            'community_id' => $community->id,
            'user_id' => auth()->id(),
            'action' => 'joined',
            'description' => auth()->user()->username . ' joined community ' . $community->name,
        ]);

        return redirect()->back()->with('success', 'Successfully joined community.');
    }

    public function leave($id)
    {
        $community = Community::findOrFail($id);

        if ($community->user_id === auth()->id()) {
            return redirect()->back()->with('error', 'Creator cannot leave the community.');
        }

        $community->members()->detach(auth()->id());

        CommunityActivity::create([
            'community_id' => $community->id,
            'user_id' => auth()->id(),
            'action' => 'left',
            'description' => auth()->user()->username . ' left community ' . $community->name,
        ]);

        return redirect()->back()->with('success', 'Successfully left community.');
    }

    public function edit(Request $request, $id)
    {
        $community = Community::findOrFail($id);

        if ($community->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized.');
        }

        $request->validate([
            'name' => 'sometimes|string|max:255|unique:communities,name,' . $id,
            'description' => 'sometimes|string',
            'is_private' => 'nullable|boolean',
        ]);

        $community->update([
            'name' => $request->input('name', $community->name),
            'description' => $request->input('description', $community->description),
            'is_private' => $request->has('is_private'),
        ]);

        CommunityActivity::create([
            'community_id' => $community->id,
            'user_id' => auth()->id(),
            'action' => 'updated',
            'description' => auth()->user()->username . ' updated community ' . $community->name,
        ]);

        return redirect('/community/' . $community->id)->with('success', 'Community updated successfully.');
    }

    public function destroy($id)
    {
        $community = Community::findOrFail($id);

        if ($community->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized.');
        }

        $community->delete();

        return redirect('/community')->with('success', 'Community deleted successfully.');
    }

    public function requestToJoin($id)
    {
        $community = Community::findOrFail($id);

        if (!$community->is_private) {
            return redirect()->back()->with('error', 'This community is public. You can join directly.');
        }

        if ($community->members()->where('user_id', auth()->id())->exists()) {
            return redirect()->back()->with('error', 'You are already a member of this community.');
        }

        $joinRequest = CommunityJoinRequest::where('community_id', $community->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($joinRequest) {
            if ($joinRequest->status === 'pending') {
                return redirect()->back()->with('error', 'You already have a pending join request.');
            }

            if ($joinRequest->status === 'approved') {
                $joinRequest->update([
                    'status' => 'pending',
                ]);

                CommunityActivity::create([
                    'community_id' => $community->id,
                    'user_id' => auth()->id(),
                    'action' => 'requested_join',
                    'description' => auth()->user()->username . ' requested to join community ' . $community->name,
                ]);
                return redirect()->back()->with('success', 'Join request submitted again.');
            }

            if ($joinRequest->status === 'rejected') {
                $joinRequest->update([
                    'status' => 'pending',
                ]);

                CommunityActivity::create([
                    'community_id' => $community->id,
                    'user_id' => auth()->id(),
                    'action' => 'requested_join',
                    'description' => auth()->user()->username . ' requested to join community ' . $community->name,
                ]);

                return redirect()->back()->with('success', 'Join request submitted again.');
            }
        }

        CommunityJoinRequest::create([
            'community_id' => $community->id,
            'user_id' => auth()->id(),
            'status' => 'pending',
        ]);

        CommunityActivity::create([
            'community_id' => $community->id,
            'user_id' => auth()->id(),
            'action' => 'requested_join',
            'description' => auth()->user()->username . ' requested to join community ' . $community->name,
        ]);

        return redirect()->back()->with('success', 'Join request sent successfully.');
    }

    public function approveRequest($id, $requestId)
    {
        $community = Community::findOrFail($id);

        if ($community->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized.');
        }

        $joinRequest = CommunityJoinRequest::where('community_id', $community->id)
            ->where('id', $requestId)
            ->where('status', 'pending')
            ->firstOrFail();

        if (!$community->members()->where('user_id', $joinRequest->user_id)->exists()) {
            $community->members()->attach($joinRequest->user_id);
        }

        $joinRequest->update([
            'status' => 'approved',
        ]);

        CommunityActivity::create([
            'community_id' => $community->id,
            'user_id' => $joinRequest->user_id,
            'action' => 'approved_request',
            'description' => $joinRequest->user->username . ' was approved to join community ' . $community->name,
        ]);

        return redirect()->back()->with('success', 'Join request approved.');
    }

    public function rejectRequest($id, $requestId)
    {
        $community = Community::findOrFail($id);

        if ($community->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized.');
        }

        $joinRequest = CommunityJoinRequest::where('community_id', $community->id)
            ->where('id', $requestId)
            ->where('status', 'pending')
            ->firstOrFail();

        $joinRequest->update([
            'status' => 'rejected',
        ]);

        CommunityActivity::create([
            'community_id' => $community->id,
            'user_id' => $joinRequest->user_id,
            'action' => 'rejected_request',
            'description' => $joinRequest->user->username . ' was rejected from community ' . $community->name,
        ]);

        return redirect()->back()->with('success', 'Join request rejected.');
    }
}
