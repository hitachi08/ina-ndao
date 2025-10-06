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
    <meta charset="utf-8">
    <title>Ina Ndao - Tenun Ikat NTT</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="keywords" />
    <meta content="" name="description" />
    <!-- Favicon -->
    <link href="/img/ina_ndao_logo.jpeg" rel="icon" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Space+Grotesk&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="/lib/animate/animate.min.css" rel="stylesheet">
    <link href="/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="/css/style.css" rel="stylesheet">
    <style>
        .event-banner {
            width: 100%;
            height: 100%;
            max-height: 400px;
            object-fit: cover;
        }

        .event-doc {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            transition: all 0.4s ease;
            cursor: pointer;
            position: relative;
            z-index: 1;
        }

        .event-doc:hover {
            position: relative;
            z-index: 10;
            transform: scale(1.5);
            object-fit: contain;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            background: #fff;
        }
    </style>

</head>

<body>
    <!-- Navbar Start -->
    <?php include "navbar.php" ?>
    <!-- Navbar End -->

    <!-- Hero Start -->
    <div class="container-fluid pb-5 bg-primary hero-header">
        <div class="container py-5">
            <div class="row g-3 align-items-center">
                <div class="col-lg-6 text-center text-lg-start">
                    <h1 class="display-1 mb-0 animated slideInLeft" style="font-size: 4rem;">Event Ina Ndao</h1>
                </div>
                <div class="col-lg-6 animated slideInRight">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center justify-content-lg-end mb-0">
                            <li class="breadcrumb-item"><a class="text-primary" href="/Beranda.php">Beranda</a></li>
                            <li class="breadcrumb-item"><a class="text-primary" href="#!">Halaman</a></li>
                            <li class="breadcrumb-item"><a class="text-primary" href="/Tentang-Ina-Ndao.php">Tentang Kami</a></li>
                            <li class="breadcrumb-item text-secondary active" aria-current="page">Detail Event</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->

    <div class="container py-5">
        <div class="container">
            <div id="event-detail"></div>
            <div id="event-docs" class="row mt-4"></div>
        </div>
    </div>

    <!-- Footer Start -->
    <?php include "footer.html" ?>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#!" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

    <script src="/js/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            let slug = "<?= htmlspecialchars($slug) ?>";

            $.ajax({
                url: "/event/detail",
                type: "POST",
                data: {
                    idOrSlug: slug
                },
                dataType: "json",
                success: function(res) {
                    if (res.status === "success") {
                        let ev = res.event;

                        // 🔹 Format tanggal: Sabtu, 08 November 2025
                        const eventDate = new Date(ev.tanggal);
                        const formattedDate = new Intl.DateTimeFormat("id-ID", {
                            weekday: "long",
                            day: "2-digit",
                            month: "long",
                            year: "numeric"
                        }).format(eventDate);

                        // 🔹 Format waktu: 08.00
                        let formattedTime = "";
                        if (ev.waktu) {
                            const [hour, minute] = ev.waktu.split(":");
                            formattedTime = `${hour.padStart(2, "0")}.${minute.padStart(2, "0")}`;
                        }

                        const today = new Date();
                        const isUpcoming = eventDate >= today;

                        const badgeHTML = isUpcoming ?
                            `<span class="badge bg-primary position-absolute top-0 start-0 m-3 px-3 py-2">Segera Hadir</span>` :
                            "";

                        let html = `
                            <div class="card shadow-sm wow fadeIn position-relative overflow-hidden">
                                ${badgeHTML}
                                <div class="row g-4 align-items-start flex-column flex-md-row">
                                    <!-- Gambar Event -->
                                    <div class="col-12 col-md-5">
                                        <img src="/img/event/${ev.gambar_banner}" 
                                             class="event-banner shadow-sm rounded w-100" 
                                             alt="${ev.nama_event}">
                                    </div>

                                    <!-- Konten Detail -->
                                    <div class="col-12 col-md-7 p-3">
                                        <h2 class="card-title mb-3 fw-bold" style="font-size: 1.8rem;">${ev.nama_event}</h2>

                                        <p class="mb-2">
                                            <i class="bi bi-geo-alt-fill me-2"></i>
                                            <strong>${ev.tempat}</strong>
                                        </p>

                                        <p class="mb-1 text-primary">
                                            <strong>${formattedDate}</strong>
                                        </p>

                                        <p class="mb-3 text-muted">
                                            ${formattedTime ? formattedTime + ' WITA' : '-'}
                                        </p>

                                        <p class="mt-3">${ev.deskripsi}</p>
                                    </div>
                                </div>
                            </div>
                        `;
                        $("#event-detail").html(html);

                        if (res.dokumentasi && res.dokumentasi.length > 0) {
                            res.dokumentasi.forEach(doc => {
                                $("#event-docs").append(`
                    <div class="col-md-3 mb-3">
                        <img src="/img/event/${doc.gambar_dokumentasi}" class="event-doc shadow" alt="Dokumentasi">
                    </div>
                `);
                            });
                        }
                    } else {
                        $("#event-detail").html(`<div class="alert alert-danger">${res.message}</div>`);
                    }
                },
            });
        });
    </script>
</body>

</html>