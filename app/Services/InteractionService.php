<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class InteractionService
{
    protected NotificationService $notifications;

    public function __construct(NotificationService $notifications)
    {
        $this->notifications = $notifications;
    }

    /**
     * Toggle a polymorphic relation like likes/reposts on a model.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable|\App\Models\User $user
     * @param Model $model
     * @param string $relation Eloquent relation name (eg 'likes', 'reposts')
     * @param string|null $notificationType optional notification type to create
     * @param string|null $notificationMessage optional message template (use :user and :title placeholders)
     * @return array ['status' => 'added'|'removed', 'count' => int]
     */
    public function toggle($user, Model $model, string $relation, ?string $notificationType = null, ?string $notificationMessage = null): array
    {
        return DB::transaction(function () use ($user, $model, $relation, $notificationType, $notificationMessage) {
            $existing = $model->$relation()->where('user_id', $user->id)->first();

            if ($existing) {
                $existing->delete();
                $status = 'removed';
            } else {
                $model->$relation()->create(['user_id' => $user->id]);
                $status = 'added';

                if ($notificationType && property_exists($model, 'user_id') && $model->user_id !== $user->id) {
                    $message = $notificationMessage ?? ($user->username . ' interacted');
                    $message = str_replace([':user', ':title'], [$user->username, $model->title ?? ''], $message);

                    $this->notifications->create(
                        $model->user_id,
                        $notificationType,
                        $message,
                        $user->id,
                        $model->id
                    );
                }
            }

            $count = $model->$relation()->count();

            return ['status' => $status, 'count' => $count];
        });
    }
}
