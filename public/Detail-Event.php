<?php
// Event-Detail.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Auth.php';
Auth::startSession();

// Ambil slug dari URL
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', trim($uri, '/'));
$slug = end($segments);
$slug = $_GET['slug'] ?? null;
if (!$slug) {
    echo "Slug tidak ditemukan";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Event</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <style>
        .event-banner {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 10px;
        }

        .event-doc {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container py-5">
        <div id="event-detail"></div>
        <div id="event-docs" class="row mt-4"></div>
    </div>

    <script src="/js/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            let slug = "<?= htmlspecialchars($slug) ?>";

            $.ajax({
                url: "/event/detail", // route ke controller
                type: "POST",
                data: {
                    idOrSlug: slug
                },
                dataType: "json",
                success: function(res) {
                    if (res.status === "success") {
                        let ev = res.event;

                        // Render detail event
                        let html = `
                    <div class="card shadow-sm">
                        <img src="/img/event/${ev.gambar_banner}" class="event-banner" alt="${ev.nama_event}">
                        <div class="card-body">
                            <h2 class="card-title">${ev.nama_event}</h2>
                            <p><strong>Tempat:</strong> ${ev.tempat}</p>
                            <p><strong>Tanggal:</strong> ${ev.tanggal} ${ev.waktu ? '('+ev.waktu+')' : ''}</p>
                            <p>${ev.deskripsi}</p>
                        </div>
                    </div>
                `;
                        $("#event-detail").html(html);

                        // Render dokumentasi (jika ada)
                        if (res.dokumentasi && res.dokumentasi.length > 0) {
                            res.dokumentasi.forEach(doc => {
                                $("#event-docs").append(`
                            <div class="col-md-3 mb-3">
                                <img src="/img/event/${doc.gambar_dokumentasi}" class="event-doc" alt="Dokumentasi">
                            </div>
                        `);
                            });
                        }
                    } else {
                        $("#event-detail").html(`<div class="alert alert-danger">${res.message}</div>`);
                    }
                },
                error: function() {
                    $("#event-detail").html(`<div class="alert alert-danger">Gagal mengambil data event</div>`);
                }
            });
        });
    </script>
</body>

</html>