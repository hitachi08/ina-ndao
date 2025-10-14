<?php

class Auth
{
    private const MAX_ATTEMPTS = 5;
    private const LOCK_TIME_SECONDS = 300;

    public static function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // register admin (use only from secure seeder)
    public static function register(PDO $pdo, string $username, string $email, string $password, string $role = 'admin')
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO admins (username, email, password_hash, role) VALUES (:username, :email, :hash, :role)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':hash' => $hash,
            ':role' => $role
        ]);
        return $pdo->lastInsertId();
    }

    // attempt login; returns true on success, false otherwise
    public static function attempt(PDO $pdo, string $usernameOrEmail, string $password): bool
    {
        self::startSession();

        // ambil record admin
        $sql = "SELECT * FROM admins WHERE username = :ue OR email = :ue LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':ue' => $usernameOrEmail]);
        $user = $stmt->fetch();

        if (!$user) {
            return false;
        }

        // check lock
        if (!empty($user['locked_until'])) {
            $lockedUntil = strtotime($user['locked_until']);
            if ($lockedUntil > time()) {
                // still locked
                return false;
            } else {
                // unlock: reset counters
                $update = $pdo->prepare("UPDATE admins SET failed_attempts = 0, locked_until = NULL WHERE id = :id");
                $update->execute([':id' => $user['id']]);
                $user['failed_attempts'] = 0;
                $user['locked_until'] = null;
            }
        }

        // verify password
        if (password_verify($password, $user['password_hash'])) {
            // sukses: reset failed attempts, simpan session, update last_login
            $u = $pdo->prepare("UPDATE admins SET failed_attempts = 0, locked_until = NULL, last_login = NOW() WHERE id = :id");
            $u->execute([':id' => $user['id']]);

            // regenerate session id to prevent fixation
            session_regenerate_id(true);
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_username'] = $user['username'];
            $_SESSION['admin_role'] = $user['role'];
            $_SESSION['admin_photo'] = $user['photo'] ?? 'default-user.png';
            $_SESSION['logged_in_at'] = time();

            return true;
        } else {
            // gagal: tambah failed_attempts
            $failed = $user['failed_attempts'] + 1;
            $lockedUntil = null;
            if ($failed >= self::MAX_ATTEMPTS) {
                $lockedUntil = date('Y-m-d H:i:s', time() + self::LOCK_TIME_SECONDS);
            }
            $update = $pdo->prepare("UPDATE admins SET failed_attempts = :failed, locked_until = :locked WHERE id = :id");
            $update->execute([
                ':failed' => $failed,
                ':locked' => $lockedUntil,
                ':id' => $user['id']
            ]);
            return false;
        }
    }

    public static function logout()
    {
        self::startSession();
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        session_destroy();
    }

    public static function check()
    {
        self::startSession();
        return isset($_SESSION['admin_id']);
    }

    public static function userId()
    {
        self::startSession();
        return $_SESSION['admin_id'] ?? null;
    }

    public static function requireLogin()
    {
        self::startSession();
        if (!self::check()) {
            header('Location: /admin/login.php');
            exit;
        }
    }

    // additional helper: require role (e.g. 'superadmin')
    public static function requireRole(string $role)
    {
        self::requireLogin();
        if (($_SESSION['admin_role'] ?? '') !== $role) {
            http_response_code(403);
            echo "403 Forbidden";
            exit;
        }
    }
}
