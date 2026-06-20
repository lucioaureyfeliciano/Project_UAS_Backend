<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
    
    public static function linkify(string $text): string
    {
        $escaped = e($text);

        $pattern = '/(https?:\/\/[^\s<]+)/i';

        return preg_replace_callback($pattern, function ($matches) {

            $url = rtrim($matches[1], '.,)');

            return '<a href="' . $url . '"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="chat-link">'
                        . $url .
                    '</a>';

        }, $escaped);
    }
}