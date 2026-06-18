<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tweet;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::with(
            'followers',
            'following'
        )->find(auth()->id());

        $tweets = Tweet::with('likes', 'reposts')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('profile', compact('user', 'tweets'))->with('isLocked', false);
    }

    public function updateDescription(Request $request)
    {
        $request->validate([
            'description' => 'nullable|string|max:500',
        ]);

        $user = auth()->user();
        $user->description = $request->description;
        $user->save();

        return back()->with('success', 'Description updated successfully');
    }

    public function show($username)
    {
        $user = User::with(
            'followers',
            'following'
        )
            ->where(
                'username',
                $username
            )
            ->firstOrFail();

        if ($user->is_private == 1 && auth()->id() != $user->id) {
            $tweets = collect();
            $isLocked = true;

            return view('profile', compact('user', 'tweets', 'isLocked'));
        }

        $tweets = Tweet::where('user_id', $user->id)
            ->with(['likes', 'dislikes', 'reposts'])
            ->latest()
            ->get();

        $isLocked = false;

        $isFollowing = false;

        if (auth()->id() != $user->id) {

            $isFollowing = \App\Models\Follow::where(
                'follower_id',
                auth()->id()
            )->where(
                    'following_id',
                    $user->id
                )->exists();

        }
        return view('profile', compact('user', 'tweets', 'isLocked', 'isFollowing'));
    }

    public function followers($username)
    {
        $user = User::with('followers.follower')
            ->where('username', $username)
            ->firstOrFail();

        return view('follows.followers', compact('user'));
    }

    public function following($username)
    {
        $user = User::with('following.following')
            ->where('username', $username)
            ->firstOrFail();

        return view('follows.following', compact('user'));
    }

    public function search(Request $request)
    {
        $keyword = $request->search;

        $type = $request->type ?? 'all';

        $users = collect();
        $tweets = collect();

        if ($type == 'all' || $type == 'users') {

            $users = User::where(
                'username',
                'like',
                '%' . $keyword . '%'
            )
                ->where(
                    'id',
                    '!=',
                    auth()->id()
                )
                ->get();

        }

        if ($type == 'all' || $type == 'tweets') {

            $tweets = Tweet::with([
                'user',
                'likes',
                'dislikes',
                'reposts',
                'comments'
            ])
                ->where(function ($query) use ($keyword) {

                    $query->where(
                        'title',
                        'like',
                        '%' . $keyword . '%'
                    )
                        ->orWhere(
                            'content',
                            'like',
                            '%' . $keyword . '%'
                        );

                })
                ->latest()
                ->get();

        }

        return view(
            'search.search',
            compact(
                'users',
                'tweets',
                'keyword',
                'type'
            )
        );
    }

    public function searchMentions(Request $request)
    {
        $keyword = strtolower($request->query('q', ''));

        if ($keyword === '') {
            return response()->json([]);
        }

        $users = User::select('username')
            ->whereRaw('LOWER(username) LIKE ?', ['%' . $keyword . '%'])
            ->where('id', '!=', auth()->id())
            ->orderByRaw(
                'CASE WHEN LOWER(username) LIKE ? THEN 0 ELSE 1 END',
                [$keyword . '%']
            )
            ->orderBy('username')
            ->limit(5)
            ->get();

        return response()->json($users);
    }

}
