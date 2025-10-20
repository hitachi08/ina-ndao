<?php
class AdminModel
{
    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT id, username, email, photo FROM admins WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($id, $username, $email)
    {
        try {
            $check = $this->pdo->prepare("SELECT id FROM admins WHERE email = ? AND id != ?");
            $check->execute([$email, $id]);
            if ($check->fetch()) {
                return ['success' => false, 'error' => 'Email sudah terdaftar.'];
            }

            $stmt = $this->pdo->prepare("UPDATE admins SET username = ?, email = ? WHERE id = ?");
            $stmt->execute([$username, $email, $id]);
            return ['success' => true];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function updatePassword($id, $newPassword)
    {
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("UPDATE admins SET password_hash = ? WHERE id = ?");
        return $stmt->execute([$hash, $id]);
    }

    public function updatePhoto($id, $filename)
    {
        $stmt = $this->pdo->prepare("UPDATE admins SET photo = ? WHERE id = ?");
        return $stmt->execute([$filename, $id]);
    }

    public function setResetToken($emailOrUsername, $token, $expiresAt)
    {
        $stmt = $this->pdo->prepare("UPDATE admins SET reset_token = ?, reset_expires = ? WHERE email = ? OR username = ?");
        return $stmt->execute([$token, $expiresAt, $emailOrUsername, $emailOrUsername]);
    }

    public function getByEmailOrUsername($identifier)
    {
        $stmt = $this->pdo->prepare("SELECT id, username, email FROM admins WHERE email = ? OR username = ?");
        $stmt->execute([$identifier, $identifier]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByResetToken($token)
    {
        $stmt = $this->pdo->prepare("SELECT id, username, email, reset_expires FROM admins WHERE reset_token = ?");
        $stmt->execute([$token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePasswordByToken($token, $newPassword)
    {
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("UPDATE admins SET password_hash = ?, remember_token = NULL, remember_expiry = NULL, reset_token = NULL, reset_expires = NULL WHERE reset_token = ?");
        return $stmt->execute([$hash, $token]);
    }

    public function clearResetToken($id)
    {
        $stmt = $this->pdo->prepare("UPDATE admins SET reset_token = NULL, reset_expires = NULL WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
