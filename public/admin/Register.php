<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/Auth.php';

Auth::startSession();

$response = ['success' => false, 'messages' => []];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax'])) {
    $token = $_POST['csrf_token'] ?? '';
    if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
        $response['messages'][] = "Invalid CSRF token.";
    } else {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $password2 = $_POST['password2'] ?? '';

        if (empty($username) || empty($email) || empty($password) || empty($password2)) {
            $response['messages'][] = "Semua field wajib diisi.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response['messages'][] = "Email tidak valid.";
        } elseif ($password !== $password2) {
            $response['messages'][] = "Password dan konfirmasi password tidak sama.";
        } else {
            $stmt = $pdo->prepare("SELECT id FROM admins WHERE username = ? OR email = ?");
            $stmt->execute([$username, $email]);
            if ($stmt->rowCount() > 0) {
                $response['messages'][] = "Username atau email sudah terdaftar.";
            } else {
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO admins (username, email, password_hash, role, failed_attempts, locked_until, created_at) VALUES (?, ?, ?, 'admin', 0, NULL, NOW())");
                $stmt->execute([$username, $email, $password_hash]);
                $response['success'] = true;
                $response['messages'][] = "Registrasi berhasil! Silakan masuk.";
            }
        }
    }
    echo json_encode($response);
    exit;
}

// CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf = $_SESSION['csrf_token'];
?>

<!doctype html>
<html lang="id">

<head>
    <title>Registrasi - Ina Ndao</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="../img/ina_ndao_logo.jpeg" rel="icon" />

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/style2.css">
    <link rel="stylesheet" href="../css/notyf.min.css">
</head>

<body class="img js-fullheight" style="background-image: url(../img/background.jpg);">
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="login-wrap p-0">
                        <h3 class="mb-4 text-center">Buat Akun Baru</h3>

                        <form id="registerForm" novalidate>
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
                            <div class="form-group">
                                <input type="text" name="username" class="form-control" placeholder="Nama Pengguna" required>
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <input id="password-field" type="password" name="password" class="form-control" placeholder="Kata Sandi" required>
                                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                            <div class="form-group">
                                <input id="password2-field" type="password" name="password2" class="form-control" placeholder="Konfirmasi Kata Sandi" required>
                                <span toggle="#password2-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary submit px-3">Daftar</button>
                            </div>
                            <p class="w-100 text-center mt-3">
                                Sudah punya akun? <a href="Login.php">Masuk di sini</a>
                            </p>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="../js/jquery.min.js"></script>
    <script src="../js/popper.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/main2.js"></script>
    <script src="../js/notyf.min.js"></script>
    <script>
        const notyf = new Notyf({
            duration: 7000,
            position: {
                x: 'right',
                y: 'top'
            }
        });

        $(document).ready(function() {
            $('#registerForm').on('submit', function(e) {
                e.preventDefault(); // cegah reload halaman
                const formData = $(this).serialize() + '&ajax=1';

                $.post('', formData, function(response) {
                    try {
                        const res = JSON.parse(response);
                        if (res.success) {
                            notyf.success(res.messages.join('<br>'));
                            $('#registerForm')[0].reset();
                        } else {
                            res.messages.forEach(msg => notyf.error(msg));
                        }
                    } catch (err) {
                        notyf.error('Terjadi kesalahan sistem.');
                    }
                });
            });
        });
    </script>
</body>

</html>