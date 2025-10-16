<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/Auth.php';
Auth::requireLogin();
$username = $_SESSION['admin_username'] ?? 'Admin';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kelola Konten - Ina Ndao</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="../img/ina_ndao_logo.jpeg" rel="icon" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link type="text/css" href="../css/volt.css" rel="stylesheet">
    <link type="text/css" href="../css/sweetalert2.min.css" rel="stylesheet">
    <style>
        .preview-img {
            display: block;
            width: 150px;
            height: 200px;
            object-fit: cover;
            margin-top: 10px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <?php include "sidebar.php"; ?>
    <main class="content">
        <?php include "navbar.php"; ?>
        <div class="container mt-4">
            <h3 class="mb-4">Kelola Konten Tentang Ina Ndao</h3>
            <form id="formTentang" enctype="multipart/form-data">
                <div id="rowsContainer"></div>

                <button type="button" id="addRow" class="btn btn-primary mt-3">
                    <i class="bi bi-plus-circle"></i> Tambah Baris
                </button>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                </div>
            </form>
        </div>
        <?php include "footer.php"; ?>
    </main>

    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/sweetalert2.all.min.js"></script>
    <script src="../js/tinymce/tinymce.min.js"></script>

    <script>
        $(function() {
            let rowsData = [];

            function renderRows() {
                $('#rowsContainer').empty();
                rowsData.forEach((row, i) => {
                    $('#rowsContainer').append(`
                        <div class="card mb-4">
                          <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                              <h5>Bagian ${i + 1}</h5>
                              <button type="button" class="btn btn-sm btn-danger removeRow" data-index="${i}">
                                <i class="bi bi-trash"></i>
                              </button>
                            </div>
                            <hr>

                            <div class="form-group mb-3">
                              <label>Gambar</label>
                              <input type="file" class="form-control gambar" accept="image/*">
                              ${row.gambar ? `<img src="${row.gambar}" class="preview-img" alt="Preview">` : ''}
                            </div>

                            <div class="form-group mb-3">
                              <label>Judul (h2)</label>
                              <input type="text" class="form-control judul" value="${row.judul ?? ''}" placeholder="Masukkan judul">
                            </div>

                            <div class="form-group mb-3">
                              <label>Paragraf 1</label>
                              <textarea class="form-control paragraf1" rows="3" placeholder="Masukkan paragraf pertama">${row.paragraf1 ?? ''}</textarea>
                            </div>

                            <div class="form-group mb-3">
                              <label>Paragraf 2</label>
                              <textarea class="form-control paragraf2" rows="3" placeholder="Masukkan paragraf kedua">${row.paragraf2 ?? ''}</textarea>
                            </div>
                          </div>
                        </div>
                    `);
                });
            }

            // Tambah baris baru
            $('#addRow').click(function() {
                rowsData.push({
                    gambar: '',
                    judul: '',
                    paragraf1: '',
                    paragraf2: ''
                });
                renderRows();
            });

            // Hapus baris
            $(document).on('click', '.removeRow', function() {
                const index = $(this).data('index');
                rowsData.splice(index, 1);
                renderRows();
            });

            // Preview gambar saat upload
            $(document).on('change', '.gambar', function() {
                const input = this;
                const file = input.files[0];
                const preview = $(this).siblings('.preview-img');

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        if (preview.length > 0) {
                            preview.attr('src', e.target.result);
                        } else {
                            $(input).after(`<img src="${e.target.result}" class="preview-img" alt="Preview">`);
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Load data dari server
            function loadKonten() {
                $.getJSON('/konten/get?halaman=tentang_ina_ndao', function(res) {
                    if (res && res.konten) {
                        try {
                            rowsData = JSON.parse(res.konten);
                        } catch (e) {
                            rowsData = [];
                        }
                    }
                    if (rowsData.length === 0) rowsData.push({
                        gambar: '',
                        judul: '',
                        paragraf1: '',
                        paragraf2: ''
                    });
                    renderRows();
                });
            }

            loadKonten();

            // Simpan data (termasuk upload file)
            $('#formTentang').on('submit', function(e) {
                e.preventDefault();

                const formData = new FormData();
                const kontenArray = [];

                $('#rowsContainer .card').each(function(i) {
                    const fileInput = $(this).find('.gambar')[0];
                    const file = fileInput.files[0];
                    const oldImage = $(this).find('.preview-img').attr('src') || '';

                    kontenArray.push({
                        gambar: oldImage, // akan diganti di server jika file baru diupload
                        judul: $(this).find('.judul').val(),
                        paragraf1: $(this).find('.paragraf1').val(),
                        paragraf2: $(this).find('.paragraf2').val()
                    });

                    if (file) {
                        formData.append(`gambar_${i}`, file);
                    }
                });

                formData.append('halaman', 'tentang_ina_ndao');
                formData.append('konten', JSON.stringify(kontenArray));

                $.ajax({
                    url: '/konten/update',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(res) {
                        Swal.fire({
                            icon: res.status,
                            title: res.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                        loadKonten();
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Gagal menyimpan konten', 'error');
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
</body>

</html>