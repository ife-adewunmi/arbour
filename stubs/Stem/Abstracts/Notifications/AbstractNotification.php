<?php

namespace App\Stem\Abstracts\Notifications;

use Illuminate\Notifications\Notification as LaravelNotification;

class AbstractNotification extends LaravelNotification
{
    public function via($notifiable): array
    {
        return config('notification.channels');
    }
}
