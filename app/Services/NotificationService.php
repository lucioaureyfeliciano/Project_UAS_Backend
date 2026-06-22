<?php

namespace App\Services;

use App\Models\Notification;

class NotificationService
{
    /**
     * Create a notification record.
     *
     * @param int $userId The user who will receive the notification
     * @param string $type Notification type (like, repost, follow, etc.)
     * @param string $message Notification message
     * @param int|null $relatedUserId The user who triggered the notification
     * @param int|string|null $tweetId Optional tweet id related to notif
     * @return Notification
     */
    public function create(int $userId, string $type, string $message, ?int $relatedUserId = null, $tweetId = null)
    {
        return Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'message' => $message,
            'is_read' => false,
            'related_user_id' => $relatedUserId,
            'tweet_id' => $tweetId,
        ]);
    }
}
