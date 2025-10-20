<?php
$token = htmlspecialchars($_GET['token'] ?? '');
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Reset Password - Ina Ndao</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="/../css/bootstrap.min.css">
    <link rel="stylesheet" href="/../css/notyf.min.css">
</head>

<body class="p-4">
    <div class="container">
        <h3>Reset Password</h3>
        <form id="resetForm" novalidate>
            <input type="hidden" name="token" value="<?= $token ?>">
            <div class="form-group">
                <label for="new_password">Password Baru</label>
                <input type="password" id="new_password" name="new_password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Konfirmasi Password</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
            </div>
            <button class="btn btn-primary" type="submit">Reset Password</button>
        </form>
    </div>

    <script src="/../js/sweetalert2.all.min.js"></script>
    <script src="/../js/jquery.min.js"></script>
    <script>
        $(function() {
            $('#resetForm').on('submit', function(e) {
                e.preventDefault();
                var newPass = $('#new_password').val();
                var conf = $('#confirm_password').val();
                if (newPass.length < 6) {
                    Swal.fire('Error', 'Password minimal 6 karakter.', 'error');
                    return;
                }
                if (newPass !== conf) {
                    Swal.fire('Error', 'Password dan konfirmasi tidak cocok.', 'error');
                    return;
                }

                var form = $(this).serialize();
                $.post('/request/change', form, function(resRaw) {
                    try {
                        var res = typeof resRaw === 'string' ? JSON.parse(resRaw) : resRaw;
                        if (res.success) {
                            Swal.fire('Sukses', res.message, 'success').then(() => {
                                window.location.href = '/admin/Login.php';
                            });
                        } else {
                            Swal.fire('Gagal', res.message, 'error');
                        }
                    } catch (e) {
                        Swal.fire('Error', 'Terjadi kesalahan server.', 'error');
                    }
                });
            });
        });
    </script>
</body>

</html>