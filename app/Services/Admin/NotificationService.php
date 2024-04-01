<?php

namespace App\Services\Admin;

use App\Models\Notification;


class NotificationService
{


    /**
     * Get Unread Notifications
     *
     * @return mixed
     */
    public function getUnreadNotifications(): mixed
    {
        return Notification::where('has_read', 0)->orderBy('created_at', 'desc')->paginate(getPerPageTotal(12));
    }

    /**
     * Get Read Notifications
     *
     * @return mixed
     */
    public function getReadNotifications(): mixed
    {
        return Notification::where('has_read', 1)->orderBy('created_at', 'desc')->paginate(getPerPageTotal(12));
    }

    /**
     * Get All Notifications
     *
     * @return mixed
     */
    public function getAllNotifications(): mixed
    {
        return Notification::orderBy('created_at', 'desc')->paginate(getPerPageTotal(12));
    }

    /**
     * Mark Notification as read
     *
     * @param $notificationIds
     * @return void
     */
    public function markAsRead($notificationIds): void
    {
        Notification::whereIn('id', $notificationIds)->update(['has_read' => 1]);
    }


}
