<?php

namespace App\Controllers;

use App\Models\NotificationModel;

class NotificationController
{
    private $model;
    public function __construct($pdo)
    {
        $this->model = new NotificationModel($pdo);
    }

    public function handle($action)
    {
        header('Content-Type: application/json; charset=utf-8');

        switch ($action) {
            case 'list':
                $data = $this->model->getLatest(10);
                echo json_encode(['status' => 'ok', 'data' => $data]);
                break;

            case 'unreadcount':
                $count = $this->model->getUnreadCount();
                echo json_encode(['status' => 'ok', 'count' => $count]);
                break;

            case 'all':
                $data = $this->model->getAll();
                echo json_encode(['status' => 'ok', 'data' => $data]);
                break;

            case 'markread':
                $id = $_POST['id'] ?? null;
                if ($id) {
                    $this->model->markAsRead($id);
                    echo json_encode(['status' => 'ok']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'id kosong']);
                }
                break;

            case 'markall':
                $this->model->markAllRead();
                echo json_encode(['status' => 'ok']);
                break;

            default:
                http_response_code(404);
                echo json_encode(['status' => 'error', 'message' => 'action not found']);
                break;
        }
    }
}
