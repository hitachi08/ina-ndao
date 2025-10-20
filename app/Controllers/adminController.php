<?php
require_once __DIR__ . '/../Models/AdminModel.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

class AdminController
{
    private $model;
    public function __construct($pdo)
    {
        $this->model = new AdminModel($pdo);

        if (file_exists(__DIR__ . '/../../vendor/autoload.php')) {
            $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
            $dotenv->safeLoad();
        }
    }

    public function handle($action)
    {
        $id = $_SESSION['admin_id'] ?? null;
        $publicActions = ['request_password_reset', 'reset_password_form', 'perform_password_reset'];

        if (!$id && !in_array($action, $publicActions)) {
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

            case 'request_password_reset':
                $this->requestPasswordReset();
                break;

            case 'reset_password_form':
                $this->showResetForm();
                break;

            case 'perform_password_reset':
                $this->performPasswordReset();
                break;

            default:
                http_response_code(404);
                echo json_encode(['status' => 'error', 'message' => 'Action tidak ditemukan']);
                break;
        }
    }

    private function requestPasswordReset()
    {
        header('Content-Type: application/json');
        $email = trim($_POST['email'] ?? '');
        if (empty($email)) {
            echo json_encode(['success' => false, 'message' => 'Email wajib diisi.']);
            return;
        }

        $user = $this->model->getByEmailOrUsername($email);
        if (!$user) {
            echo json_encode(['success' => true, 'message' => 'Jika email terdaftar, instruksi reset telah dikirim.']);
            return;
        }

        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', time() + 3600);

        if (!$this->model->setResetToken($email, $token, $expiresAt)) {
            echo json_encode(['success' => false, 'message' => 'Gagal membuat token reset.']);
            return;
        }

        $host = ($_SERVER['HTTPS'] ?? 'off') !== 'off' ? 'https' : 'http';
        $host .= '://' . $_SERVER['HTTP_HOST'];
        $resetLink = $host . '/reset-password/' . $token;

        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = $_ENV['MAIL_HOST'] ?? 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['MAIL_USERNAME'] ?? '';
            $mail->Password = $_ENV['MAIL_PASSWORD'] ?? '';
            $mail->SMTPSecure = $_ENV['MAIL_ENCRYPTION'] ?? 'tls';
            $mail->Port = $_ENV['MAIL_PORT'] ?? 587;

            $mail->setFrom($_ENV['MAIL_FROM_ADDRESS'] ?? $mail->Username, $_ENV['MAIL_FROM_NAME'] ?? 'Ina Ndao Support');
            $mail->addAddress($user['email'], $user['username']);

            $mail->isHTML(true);
            $mail->Subject = 'Permintaan Reset Password';
            $mail->Body = "
                <p>Halo <strong>{$user['username']}</strong>,</p>
                <p>Kami menerima permintaan reset password. Klik tautan di bawah untuk mengatur ulang password Anda (kadaluarsa 1 jam):</p>
                <p><a href=\"{$resetLink}\">Reset Password</a></p>
                <p>Jika tombol di atas tidak bekerja, salin alamat ini ke browser Anda:</p>
                <p>{$resetLink}</p>
                <p>Jika Anda tidak meminta reset password, abaikan email ini.</p>
            ";

            $mail->send();

            echo json_encode(['success' => true, 'message' => 'Jika email terdaftar, instruksi reset telah dikirim.']);
            return;
        } catch (Exception $e) {
            error_log('Mail error: ' . $mail->ErrorInfo);
            echo json_encode(['success' => true, 'message' => 'Jika email terdaftar, instruksi reset telah dikirim.']); // tetap generic
            return;
        }
    }

    private function showResetForm()
    {
        $token = $_GET['token'] ?? '';
        $user = $this->model->findByResetToken($token);
        if (!$user || empty($user['reset_expires']) || strtotime($user['reset_expires']) < time()) {
            include __DIR__ . '/../../public/admin/invalid.php';
            return;
        }

        $_GET['token'] = $token;
        include __DIR__ . '/../../public/admin/reset_password_form.php';
    }

    private function performPasswordReset()
    {
        header('Content-Type: application/json');
        $token = $_POST['token'] ?? '';
        $newPass = $_POST['new_password'] ?? '';
        if (empty($token) || empty($newPass)) {
            echo json_encode(['success' => false, 'message' => 'Data tidak lengkap.']);
            return;
        }

        $user = $this->model->findByResetToken($token);
        if (!$user) {
            echo json_encode(['success' => false, 'message' => 'Token tidak valid atau sudah digunakan.']);
            return;
        }
        if (empty($user['reset_expires']) || strtotime($user['reset_expires']) < time()) {
            echo json_encode(['success' => false, 'message' => 'Token telah kadaluarsa. Silakan ajukan permintaan ulang.']);
            return;
        }

        $ok = $this->model->updatePasswordByToken($token, $newPass);
        if ($ok) {
            echo json_encode(['success' => true, 'message' => 'Password berhasil diubah. Silakan masuk.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal mengubah password.']);
        }
    }
}
