<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/Auth.php';
Auth::requireLogin();

$username = $_SESSION['admin_username'] ?? 'Admin';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Kelola Event - Ina Ndao</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <link href="../img/ina_ndao_logo.jpeg" rel="icon" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link type="text/css" href="../css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="../css/volt.css" rel="stylesheet">
    <link type="text/css" href="../css/sweetalert2.min.css" rel="stylesheet">
</head>

<body>
    <!-- Sidebar -->
    <?php include "sidebar.php"; ?>

    <main class="content">

        <?php include "navbar.php" ?>

        <?php include "footer.php" ?>
    </main>

    <!-- JS -->
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/sweetalert2.all.min.js"></script>

</body>

</html>