<?php

namespace App\CommandProcess\Admin\Notification;

use App\Services\Admin\NotificationService;
use Rosamarsky\CommandBus\Command;
use Rosamarsky\CommandBus\Handler;

class GetUnreadNotificationsHandler implements Handler
{
    private NotificationService $dbService;

    public function __construct(NotificationService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function handle(Command $command)
    {
        return $this->dbService->getUnreadNotifications();
    }
}
