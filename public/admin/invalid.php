<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Reset Password Tidak Valid - Ina Ndao</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="/../css/bootstrap.min.css">
    <link rel="stylesheet" href="/../css/notyf.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            height: 100vh;
            align-items: center;
            justify-content: center;
        }

        .card {
            max-width: 420px;
            border-radius: 1rem;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            text-align: center;
        }

        .btn-primary {
            border-radius: 50px;
        }

        svg {
            width: 80px;
            height: 80px;
        }
    </style>
</head>

<body>
    <div class="card p-3">
        <div class="card-body">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="10" fill="#f8d7da" />
                <path d="M12 7v5" stroke="#721c24" stroke-width="2" stroke-linecap="round" />
                <circle cx="12" cy="15.5" r="1" fill="#721c24" />
                <path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20z" stroke="#721c24" stroke-width="1" />
            </svg>

            <h4 class="text-danger mb-2 mt-3">Link Tidak Valid</h4>
            <p class="text-muted mb-3">
                Token reset password tidak valid, sudah digunakan, atau sudah kadaluarsa.
            </p>
            <a href="/admin/Login.php" class="btn btn-primary">Kembali ke Login</a>
        </div>
    </div>

    <script src="/../js/sweetalert2.all.min.js"></script>
</body>

</html>