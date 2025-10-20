<?php

class Auth
{
    private const MAX_ATTEMPTS = 5;
    private const LOCK_TIME_SECONDS = 300;
    private const REMEMBER_DAYS = 7;

    public static function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

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

    public static function attempt(PDO $pdo, string $usernameOrEmail, string $password, bool $remember = false): bool
    {
        self::startSession();

        $sql = "SELECT * FROM admins WHERE username = :ue OR email = :ue LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':ue' => $usernameOrEmail]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) return false;

        // check lock
        if (!empty($user['locked_until'])) {
            if (strtotime($user['locked_until']) > time()) {
                return false;
            } else {
                $pdo->prepare("UPDATE admins SET failed_attempts = 0, locked_until = NULL WHERE id = :id")
                    ->execute([':id' => $user['id']]);
            }
        }

        if (password_verify($password, $user['password_hash'])) {
            $pdo->prepare("UPDATE admins SET failed_attempts = 0, locked_until = NULL, last_login = NOW() WHERE id = :id")
                ->execute([':id' => $user['id']]);

            self::setSession($user);

            if ($remember) {
                self::setRememberToken($pdo, $user['id']);
            }

            return true;
        } else {
            $failed = $user['failed_attempts'] + 1;
            $lockedUntil = null;
            if ($failed >= self::MAX_ATTEMPTS) {
                $lockedUntil = date('Y-m-d H:i:s', time() + self::LOCK_TIME_SECONDS);
            }

            $pdo->prepare("UPDATE admins SET failed_attempts = :f, locked_until = :l WHERE id = :id")
                ->execute([':f' => $failed, ':l' => $lockedUntil, ':id' => $user['id']]);
            return false;
        }
    }

    private static function setSession(array $user)
    {
        session_regenerate_id(true);
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['admin_username'] = $user['username'];
        $_SESSION['admin_role'] = $user['role'];
        $_SESSION['admin_photo'] = $user['photo'] ?? 'default-user.png';
        $_SESSION['logged_in_at'] = time();
    }

    private static function setRememberToken(PDO $pdo, int $id)
    {
        $token = bin2hex(random_bytes(32));
        $expiry = date('Y-m-d H:i:s', time() + self::REMEMBER_DAYS * 86400);

        $stmt = $pdo->prepare("UPDATE admins SET remember_token = :t, remember_expiry = :e WHERE id = :id");
        $stmt->execute([':t' => $token, ':e' => $expiry, ':id' => $id]);

        setcookie('remember_token', $token, time() + self::REMEMBER_DAYS * 86400, '/', '', false, true);
    }

    public static function autoLogin(PDO $pdo): bool
    {
        self::startSession();

        if (isset($_SESSION['admin_id'])) {
            return true;
        }

        if (isset($_COOKIE['remember_token'])) {
            $token = $_COOKIE['remember_token'];

            $stmt = $pdo->prepare("SELECT * FROM admins WHERE remember_token = :t AND remember_expiry > NOW() LIMIT 1");
            $stmt->execute([':t' => $token]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                self::setSession($user);
                return true;
            } else {
                setcookie('remember_token', '', time() - 3600, '/');
            }
        }

        return false;
    }

    public static function logout(?PDO $pdo = null)
    {
        self::startSession();

        if ($pdo && isset($_SESSION['admin_id'])) {
            $stmt = $pdo->prepare("UPDATE admins SET remember_token = NULL, remember_expiry = NULL WHERE id = ?");
            $stmt->execute([$_SESSION['admin_id']]);
        }

        if (isset($_COOKIE['remember_token'])) {
            setcookie('remember_token', '', time() - 3600, '/');
        }

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

    public static function check(): bool
    {
        self::startSession();
        return isset($_SESSION['admin_id']);
    }

    public static function userId()
    {
        self::startSession();
        return $_SESSION['admin_id'] ?? null;
    }

    public static function requireLogin(?PDO $pdo = null)
    {
        self::startSession();

        if (!self::check()) {
            if ($pdo && self::autoLogin($pdo)) {
                return;
            }
            header('Location: /admin/Login.php');
            exit;
        }
    }

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
