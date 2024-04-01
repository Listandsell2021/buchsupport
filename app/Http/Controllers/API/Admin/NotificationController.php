<?php

namespace App\Http\Controllers\API\Admin;

use App\CommandProcess\Admin\Notification\GetAllNotifications;
use App\CommandProcess\Admin\Notification\GetReadNotifications;
use App\CommandProcess\Admin\Notification\GetUnreadNotifications;
use App\CommandProcess\Admin\Notification\MarkNotificationsRead;
use App\Helpers\Trait\ApiResponseHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Notification\MarkNotificationReadRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Rosamarsky\CommandBus\CommandBus;

class NotificationController extends Controller
{
    use ApiResponseHelpers;

    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }


    /**
     * Get unread notifications
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getUnreadNotifications(Request $request): JsonResponse
    {
        $notifications = $this->commandBus->execute(new GetUnreadNotifications());

        return $this->respondWithSuccess('Unread notifications fetched successfully', $notifications);
    }


    /**
     * Get read notifications
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getReadNotifications(Request $request): JsonResponse
    {
        $notifications = $this->commandBus->execute(new GetReadNotifications());

        return $this->respondWithSuccess('Read notifications fetched successfully', $notifications);
    }

    /**
     * Get all notifications
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getAllNotifications(Request $request): JsonResponse
    {
        $notifications = $this->commandBus->execute(new GetAllNotifications());

        return $this->respondWithSuccess('All notifications fetched successfully', $notifications);
    }


    /**
     * Get Unread Notifications
     *
     * @param MarkNotificationReadRequest $request
     * @return JsonResponse
     */
    public function markAsRead(MarkNotificationReadRequest $request): JsonResponse
    {
        $this->commandBus->execute(new MarkNotificationsRead((array) $request->get('notification_ids')));

        return $this->respondWithSuccess('Notification read successfully');
    }



}
