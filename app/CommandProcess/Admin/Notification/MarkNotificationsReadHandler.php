<?php

namespace App\CommandProcess\Admin\Notification;

use App\Services\Admin\NotificationService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class MarkNotificationsReadHandler implements Handler
{

    private NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function handle(Command $command)
    {
        $this->notificationService->markAsRead(array_unique($command->notificationIds));
    }
}
