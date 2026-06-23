<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use App\Services\InteractionService;

class LikeController extends Controller
{
    protected InteractionService $interactions;

    public function __construct(InteractionService $interactions)
    {
        $this->interactions = $interactions;
    }

    public function toggle(Tweet $tweet)
    {
        $user = auth()->user();

        $result = $this->interactions->toggle(
            $user,
            $tweet,
            'likes',
            'like',
            ':user liked your tweet ":title"'
        );

        return request()->expectsJson()
            ? response()->json(['count' => $result['count'], 'status' => $result['status']])
            : redirect()->back();
    }
}