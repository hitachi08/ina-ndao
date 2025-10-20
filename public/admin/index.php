<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/Auth.php';
Auth::requireLogin($pdo);
$username = $_SESSION['admin_username'] ?? 'Admin';

?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Dashboard - Ina Ndao</title>
    <link href="../img/ina_ndao_logo.jpeg" rel="icon" />

    <link href="/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="/css/volt.css" rel="stylesheet">
    <style>
        .dataTables_info,
        .dataTables_length label {
            padding-left: 0 !important;
        }

        .dataTables_paginate,
        .dataTables_filter {
            padding-right: 0 !important;
        }

        div.dataTables_wrapper div.dataTables_length select {
            padding-right: 1.5rem !important;
            background-position: right 6px center !important;
        }

        .stat-elegant {
            border-radius: 1rem;
            transition: all 0.3s ease;
        }

        .stat-elegant:hover {
            transform: translateY(-3px);
            box-shadow: 0 0.8rem 1.6rem rgba(0, 0, 0, 0.08);
        }

        /* Ikon bundar dengan warna pastel */
        .icon-box {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            transition: 0.3s;
        }

        .icon-box i {
            color: #6c757d;
        }

        .bg-soft-primary {
            background-color: #e5ecf6;
        }

        .bg-soft-success {
            background-color: #e8f5ec;
        }

        .bg-soft-warning {
            background-color: #fdf4e5;
        }

        .bg-soft-info {
            background-color: #e9f4f7;
        }

        .elegant-list .list-group-item {
            border: none;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f1f1f1;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .elegant-list .list-group-item:last-child {
            border-bottom: none;
        }

        .elegant-list .list-group-item:hover {
            background: #f8f9fa;
        }

        .elegant-list small {
            color: #6c757d;
            font-weight: 500;
        }

        .card-body h6 {
            letter-spacing: 0.3px;
        }
    </style>
</head>

<body>
    <?php include 'sidebar.php'; ?>
    <main class="content">
        <?php include 'navbar.php'; ?>

        <div class="row g-3 py-4">
            <div class="col-6 col-lg-3">
                <div class="card stat-elegant shadow-sm border-0 bg-kain">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fw-semibold text-muted mb-1">Kain Tenun</h6>
                            <h2 id="stat-kain" class="fw-bold mb-0 text-dark">--</h2>
                        </div>
                        <div class="icon-box bg-soft-primary">
                            <i class="bi bi-flower3"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="card stat-elegant shadow-sm border-0 bg-produk">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fw-semibold text-muted mb-1">Produk Olahan</h6>
                            <h2 id="stat-produk" class="fw-bold mb-0 text-dark">--</h2>
                        </div>
                        <div class="icon-box bg-soft-success">
                            <i class="bi bi-basket2"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="card stat-elegant shadow-sm border-0 bg-event">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fw-semibold text-muted mb-1">Event</h6>
                            <h2 id="stat-event" class="fw-bold mb-0 text-dark">--</h2>
                        </div>
                        <div class="icon-box bg-soft-warning">
                            <i class="bi bi-calendar-event"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="card stat-elegant shadow-sm border-0 bg-tim">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fw-semibold text-muted mb-1">Tim Ina Ndao</h6>
                            <h2 id="stat-team" class="fw-bold mb-0 text-dark">--</h2>
                        </div>
                        <div class="icon-box bg-soft-info">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4 border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 d-flex align-items-center">
                <i class="bi bi-calendar2-week text-muted fs-5 me-2"></i>
                <h5 class="mb-0 text-dark fw-semibold">Event Mendatang</h5>
            </div>
            <div class="card-body">
                <ul id="list-upcoming" class="list-group list-group-flush elegant-list"></ul>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h6>Data Kain Tenun</h6>
            </div>
            <div class="card-body">
                <table id="table-kain" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis</th>
                            <th>Daerah</th>
                            <th>Ukuran</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        <?php include 'footer.php'; ?>
    </main>

    <div class="modal fade" id="modalDetailKain" tabindex="-1" aria-labelledby="modalDetailKainLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDetailKainLabel">Detail Kain Tenun</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5 text-center">
                            <img id="detail-gambar" src="" alt="Gambar Kain" class="img-fluid rounded mb-3 shadow" style="max-height: 300px;">
                        </div>
                        <div class="col-md-7">
                            <table class="table table-bordered">
                                <tr>
                                    <th>ID</th>
                                    <td id="detail-id"></td>
                                </tr>
                                <tr>
                                    <th>Jenis Kain</th>
                                    <td id="detail-jenis"></td>
                                </tr>
                                <tr>
                                    <th>Daerah Asal</th>
                                    <td id="detail-daerah"></td>
                                </tr>
                                <tr>
                                    <th>Ukuran</th>
                                    <td id="detail-ukuran"></td>
                                </tr>
                                <tr>
                                    <th>Harga</th>
                                    <td id="detail-harga"></td>
                                </tr>
                                <tr>
                                    <th>Bahan</th>
                                    <td id="detail-bahan"></td>
                                </tr>
                                <tr>
                                    <th>Jenis Pewarna</th>
                                    <td id="detail-pewarna"></td>
                                </tr>
                                <tr>
                                    <th>Stok</th>
                                    <td id="detail-stok"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="/js/jquery.dataTables.min.js"></script>
    <script src="/js/dataTables.bootstrap5.min.js"></script>
    <script src="/js/sweetalert2.all.min.js"></script>
    <script>
        $(function() {

            $.getJSON('/admin/api/stats', function(res) {
                if (res.success) {
                    const s = res.data.stats;
                    $('#stat-kain').text(s.kain_total);
                    $('#stat-produk').text(s.produk_total);
                    $('#stat-event').text(s.event_total);
                    $('#stat-team').text(s.team_total + ' Orang');

                    const events = res.data.upcoming_events;
                    const ul = $('#list-upcoming');
                    ul.empty();
                    if (!events.length) {
                        ul.append('<li class="list-group-item text-muted">Tidak ada event mendatang</li>');
                    } else {
                        events.forEach(e => {
                            ul.append(`
                        <li class="list-group-item d-flex justify-content-between">
                            <span>${e.nama_event}</span>
                            <small>${e.tanggal}</small>
                        </li>
                    `);
                        });
                    }
                } else {
                    console.error('Gagal memuat statistik');
                }
            });

            var table = $('#table-kain').DataTable({
                ajax: {
                    url: '/admin/api/kain/list',
                    dataSrc: '',
                },
                columns: [{
                        data: null,
                        render: (data, type, row, meta) => meta.row + 1,
                        className: 'text-center'
                    },
                    {
                        data: 'jenis_kain'
                    },
                    {
                        data: 'daerah_asal'
                    },
                    {
                        data: 'ukuran',
                        render: data => data.replace(/(\d+)(?:[.,]0+)?/g, '$1')
                    },
                    {
                        data: 'harga',
                        render: data => 'Rp ' + Number(data).toLocaleString('id-ID')
                    },
                    {
                        data: null,
                        orderable: false,
                        render: d => `
                    <button class="btn btn-sm btn-primary btn-detail" data-id="${d.id_kain}">
                        Detail
                    </button>
                `
                    }
                ],
                pageLength: 5,
                lengthMenu: [
                    [5, 10, 25, 50],
                    [5, 10, 25, 50]
                ],
                pagingType: 'full_numbers',
                language: {
                    lengthMenu: "Menampilkan _MENU_ Data",
                    info: "Menampilkan _START_ sampai _END_ dari total _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 sampai 0 dari total 0 data",
                    infoFiltered: "(disaring dari total _MAX_ data)",
                    zeroRecords: "Tidak ada data yang cocok ditemukan",
                    emptyTable: "Tidak ada data tersedia di tabel ini",
                    paginate: {
                        first: '<i class="bi bi-chevron-double-left"></i>',
                        previous: '<i class="bi bi-chevron-left"></i>',
                        next: '<i class="bi bi-chevron-right"></i>',
                        last: '<i class="bi bi-chevron-double-right"></i>'
                    },
                    search: '',
                    searchPlaceholder: 'Cari...'
                },
                drawCallback: function() {
                    $('.dataTables_paginate ul.pagination')
                        .addClass('justify-content-end mb-0')
                        .find('li')
                        .addClass('page-item');
                    $('.dataTables_paginate ul.pagination li a')
                        .addClass('page-link rounded-2');

                    if (!$('.dataTables_filter .input-group').length) {
                        let input = $('.dataTables_filter input');
                        input
                            .addClass('form-control border-start-0 shadow-none')
                            .wrap('<div class="input-group"></div>')
                            .before(`
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                    `);
                    }
                }
            });

            $('#table-kain').on('click', '.btn-detail', function() {
                const data = table.row($(this).parents('tr')).data();

                $('#detail-id').text(data.id_kain);
                $('#detail-jenis').text(data.jenis_kain);
                $('#detail-daerah').text(data.daerah_asal);
                $('#detail-ukuran').text(data.ukuran);
                $('#detail-harga').text('Rp ' + Number(data.harga).toLocaleString('id-ID'));
                $('#detail-bahan').text(data.bahan || '-');
                $('#detail-pewarna').text(data.jenis_pewarna || '-');
                $('#detail-stok').text(data.stok ?? '-');

                if (data.path_gambar) {
                    $('#detail-gambar')
                        .attr('src', '/uploads/motif/' + data.path_gambar)
                        .show();
                } else {
                    $('#detail-gambar').hide();
                }

                $('#modalDetailKain').modal('show');
            });

        });
    </script>

</body>

</html>