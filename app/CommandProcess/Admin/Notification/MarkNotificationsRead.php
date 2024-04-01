<?php

namespace App\CommandProcess\Admin\Notification;

use Rosamarsky\CommandBus\Command;

class MarkNotificationsRead implements Command
{
    public array $notificationIds;

    public function __construct(array $notificationIds)
    {
        $this->notificationIds = $notificationIds;
    }
}
