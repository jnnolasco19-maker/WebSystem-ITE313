<?php

namespace App\Controllers;

use App\Models\NotificationModel;
use CodeIgniter\Controller;

class Notifications extends Controller
{
    public function get()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized',
            ])->setStatusCode(401);
        }

        $userId = $session->get('userID');
        $model = new NotificationModel();

        $count = $model->getUnreadCount($userId);
        $notifications = $model->getNotificationsForUser($userId);

        return $this->response->setJSON([
            'success' => true,
            'count' => $count,
            'notifications' => $notifications,
        ]);
    }

    public function mark_as_read($id)
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized',
            ])->setStatusCode(401);
        }

        $userId = $session->get('userID');
        $model = new NotificationModel();

        // Ensure the notification belongs to the current user
        $notification = $model->where(['id' => $id, 'user_id' => $userId])->first();
        if (!$notification) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Not found',
            ])->setStatusCode(404);
        }

        $updated = $model->markAsRead($id);

        return $this->response->setJSON([
            'success' => (bool) $updated,
        ]);
    }
}


