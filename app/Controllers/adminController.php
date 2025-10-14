<?php
require_once __DIR__ . '/../Models/AdminModel.php';

class AdminController
{
    private $model;
    public function __construct($pdo)
    {
        $this->model = new AdminModel($pdo);
    }

    public function handle($action)
    {
        $id = $_SESSION['admin_id'] ?? null;
        if (!$id) {
            http_response_code(403);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        switch ($action) {
            case 'getprofile':
                $data = $this->model->getById($id);
                echo json_encode($data);
                break;

            case 'updateprofile':
                $username = $_POST['username'];
                $email = $_POST['email'];
                $result = $this->model->updateProfile($id, $username, $email);

                header('Content-Type: application/json');
                echo json_encode($result);
                break;

            case 'updatepassword':
                $newPass = $_POST['new_password'];
                $success = $this->model->updatePassword($id, $newPass);
                echo json_encode(['success' => $success]);
                break;

            case 'updatephoto':
                if (!empty($_FILES['photo']['name'])) {
                    $targetDir = __DIR__ . '/../../public/uploads/admin/';
                    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

                    $filename = 'admin_' . $id . '_' . time() . '.' . pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                    $path = $targetDir . $filename;

                    if (move_uploaded_file($_FILES['photo']['tmp_name'], $path)) {
                        $this->model->updatePhoto($id, $filename);
                        $_SESSION['admin_photo'] = $filename;
                        echo json_encode(['success' => true, 'photo' => $filename]);
                    } else {
                        echo json_encode(['success' => false, 'error' => 'Upload failed']);
                    }
                }
                break;
        }
    }
}
