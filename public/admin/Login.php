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
		$ue = trim($_POST['username'] ?? '');
		$pw = $_POST['password'] ?? '';

		if (empty($ue) || empty($pw)) {
			$response['messages'][] = "Username/email dan password wajib diisi.";
		} else {
			if (Auth::attempt($pdo, $ue, $pw)) {
				$response['success'] = true;
				$response['messages'][] = "Login berhasil! Mengalihkan...";
			} else {
				$stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ? OR email = ?");
				$stmt->execute([$ue, $ue]);
				$user = $stmt->fetch(PDO::FETCH_ASSOC);

				if ($user) {
					if (!empty($user['locked_until']) && strtotime($user['locked_until']) > time()) {
						$minutesLeft = ceil((strtotime($user['locked_until']) - time()) / 60);
						$response['messages'][] = "Akun dikunci selama $minutesLeft menit. Silahkan coba lagi nanti.";
					} else {
						$response['messages'][] = "Login gagal — periksa username/email atau password.";
					}
				} else {
					$response['messages'][] = "Login gagal — periksa username/email atau password.";
				}
			}
		}
	}
	echo json_encode($response);
	exit;
}

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
	$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf = $_SESSION['csrf_token'];
?>


<!doctype html>
<html lang="id">

<head>
	<title>Login - Ina Ndao</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="../img/ina_ndao_logo.jpeg" rel="icon" />

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/style2.css">
	<link rel="stylesheet" href="../css/notyf.min.css">
</head>

<body class="img js-fullheight" style="background-image: url(../img/bg.jpg);">
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-4">
					<div class="login-wrap p-0">
						<h3 class="mb-4 text-center">Selamat Datang di Ina Ndao</h3>

						<form id="loginForm" novalidate>
							<input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">
							<div class="form-group">
								<input type="text" name="username" class="form-control" placeholder="Nama Pengguna atau Email" required>
							</div>
							<div class="form-group">
								<input id="password-field" type="password" name="password" class="form-control" placeholder="Kata Sandi" required>
								<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
							</div>
							<div class="form-group">
								<button type="submit" class="form-control btn btn-primary submit px-3">Masuk</button>
							</div>
							<div class="form-group d-flex">
								<div class="w-50">
									<label class="checkbox-wrap checkbox-primary">Ingat Saya
										<input type="checkbox" checked>
										<span class="checkmark"></span>
									</label>
								</div>
								<div class="w-50 text-right">
									<a href="#" style="color: #fff">Lupa Password?</a>
								</div>
							</div>
						</form>

						<p class="w-100 text-center mt-3">
							Belum punya akun? <a href="Register.php">Daftar di sini</a>
						</p>

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
			$('#loginForm').on('submit', function(e) {
				e.preventDefault(); // cegah reload
				const formData = $(this).serialize() + '&ajax=1';

				$.post('', formData, function(response) {
					try {
						const res = JSON.parse(response);
						if (res.success) {
							notyf.success(res.messages.join('<br>'));
							setTimeout(() => {
								window.location.href = 'Dashboard.php';
							}, 1000);
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