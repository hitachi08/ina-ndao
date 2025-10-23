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
        .foto-preview {
            width: 60px;
            height: 80px;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <?php include "sidebar.php"; ?>

    <main class="content">
        <?php include "navbar.php"; ?>

        <div class="container mt-4">
            <h3 class="mb-3">Kelola Konten Beranda</h3>

            <ul class="nav nav-tabs" id="kontenTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="sejarah-tab" data-bs-toggle="tab" href="#tabSejarah" role="tab">Sejarah Ina Ndao</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="team-tab" data-bs-toggle="tab" href="#tabTeam" role="tab">Team Ina Ndao</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="promosi-tab" data-bs-toggle="tab" href="#tabPromosi" role="tab">Promosi Ina Ndao</a>
                </li>
            </ul>

            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="tabSejarah" role="tabpanel">
                    <form id="formSejarah">
                        <input type="hidden" name="halaman" value="beranda_sejarah">
                        <textarea id="editorSejarah" name="konten" rows="20" class="form-control"></textarea>
                        <button type="submit" class="btn btn-success mt-3">Simpan Sejarah</button>
                    </form>
                </div>

                <div class="tab-pane fade" id="tabTeam" role="tabpanel">
                    <form id="formTeam">
                        <input type="hidden" name="halaman" value="beranda_team">

                        <div id="teamWrapper">
                            <div class="team-member row g-2 mb-3 align-items-end">
                                <div class="col-md-4">
                                    <label>Nama</label>
                                    <input type="text" class="form-control nama" placeholder="Nama anggota">
                                </div>
                                <div class="col-md-4">
                                    <label>Jabatan</label>
                                    <input type="text" class="form-control jabatan" placeholder="Jabatan">
                                </div>
                                <div class="col-md-3">
                                    <label>Foto</label>
                                    <input type="file" class="form-control fotoFile" accept="image/*">
                                    <input type="hidden" class="foto" value="">
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-danger btn-sm remove-member">×</button>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between pt-4">
                            <button type="button" id="addMember" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Tambah Input
                            </button>
                            <button type="submit" class="btn btn-success">Simpan Team</button>
                        </div>
                    </form>
                </div>

                <div class="tab-pane fade" id="tabPromosi" role="tabpanel">
                    <form id="formPromosi">
                        <input type="hidden" name="halaman" value="beranda_promosi">

                        <div id="promosiWrapper"></div>

                        <div class="d-flex align-items-center justify-content-between pt-4">
                            <button type="button" id="addPromosi" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Tambah Input
                            </button>
                            <button type="submit" class="btn btn-success">Simpan Promosi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php include "footer.php"; ?>
    </main>

    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/sweetalert2.all.min.js"></script>
    <script src="../js/tinymce/tinymce.min.js"></script>

    <script>
        tinymce.init({
            selector: '#editorSejarah',
            license_key: 'gpl',
            promotion: false,
            branding: false,
            height: 600,
            plugins: 'image media link table code fullscreen',
            toolbar: [
                'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen preview save print | insertfile image media template link anchor codesample | ltr rtl'
            ],
            toolbar_sticky: true,
            autosave_ask_before_unload: true,
            image_advtab: true,
            importcss_append: true,
            quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
            contextmenu: 'link image imagetools table',
            skin: 'oxide',
            content_css: 'default',
            relative_urls: false,
            remove_script_host: false,
            setup: (editor) => {
                editor.on('init', () => {
                    loadKontenSejarah();
                });
            }
        });

        function loadKontenSejarah() {
            $.getJSON('/konten/get?halaman=beranda_sejarah', function(res) {
                if (res && res.konten) {
                    tinymce.get('editorSejarah').setContent(res.konten);
                }
            });
        }

        function loadKontenTeam() {
            $.getJSON('/konten/get?halaman=beranda_team', function(res) {
                if (res && res.konten) {
                    try {
                        const data = JSON.parse(res.konten);
                        $('#teamWrapper').empty();

                        data.team.forEach(member => {
                            const row = `
                        <div class="team-member row g-2 align-items-start mb-4">
                            <div class="col-md-3">
                                <input type="text" class="form-control nama" value="${member.nama}" placeholder="Nama anggota">
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control jabatan" value="${member.jabatan}" placeholder="Jabatan">
                            </div>
                            <div class="col-md-4">
                                <input type="file" class="form-control fotoFile" accept="image/*">
                                <input type="hidden" class="foto" value="${member.foto}">
                            </div>
                            <div class="col-md-1 text-left preview-container">
                                ${member.foto ? `<img src="${member.foto}" class="foto-preview img-fluid rounded" alt="Preview">` : ''}
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger btn-sm remove-member">×</button>
                            </div>
                        </div>`;
                            $('#teamWrapper').append(row);
                        });
                    } catch (e) {
                        console.error('Error parsing JSON team:', e);
                        $('#teamWrapper').html('<div class="text-danger">Data tidak valid, silakan simpan ulang.</div>');
                    }
                }
            }).fail(function(xhr) {
                console.error('Gagal memuat data team:', xhr.responseText);
            });
        }

        $('#addMember').on('click', function() {
            const template = `
            <div class="team-member row g-2 align-items-start mb-4">
                <div class="col-md-3">
                    <input type="text" class="form-control nama" placeholder="Nama anggota">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control jabatan" placeholder="Jabatan">
                </div>
                <div class="col-md-4">
                    <input type="file" class="form-control fotoFile" accept="image/*">
                    <input type="hidden" class="foto" value="">
                </div>
                <div class="col-md-1 text-left preview-container"></div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger btn-sm remove-member">×</button>
                </div>
            </div>`;
            $('#teamWrapper').append(template);
        });

        $(document).on('click', '.remove-member', function() {
            $(this).closest('.team-member').remove();
        });

        $(document).on('change', '.fotoFile', function() {
            const fileInput = this;
            const hiddenInput = $(this).siblings('.foto');
            const previewContainer = $(this).closest('.team-member').find('.preview-container');

            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    previewContainer.html(`<img src="${e.target.result}" class="foto-preview img-fluid rounded" alt="Preview">`);
                };

                reader.readAsDataURL(fileInput.files[0]);

                const formData = new FormData();
                formData.append('file', fileInput.files[0]);

                $.ajax({
                    url: '/konten/upload_team_foto',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(res) {
                        if (res.filePath) {
                            hiddenInput.val(res.filePath);
                        } else {
                            Swal.fire('Error', 'Gagal upload foto', 'error');
                        }
                    },
                    error: function(xhr) {
                        console.error('Upload error:', xhr.responseText);
                        Swal.fire('Error', 'Gagal upload foto', 'error');
                    }
                });
            }
        });

        function loadKontenPromosi() {
            $.getJSON('/konten/get?halaman=beranda_promosi', function(res) {
                if (res && res.konten) {
                    try {
                        const data = JSON.parse(res.konten);
                        const wrapper = $('#promosiWrapper');
                        wrapper.empty();

                        if (data.promosi && Array.isArray(data.promosi)) {
                            data.promosi.forEach(item => {
                                addPromosiField(item.judul, item.teks);
                            });
                        }
                    } catch (e) {
                        console.error('Invalid JSON format in promosi:', e);
                        Swal.fire({
                            icon: 'warning',
                            title: 'Format data tidak valid',
                            text: 'Data promosi belum berformat JSON yang benar.'
                        });
                    }
                }
            }).fail(function(xhr) {
                console.error('Gagal memuat data promosi:', xhr.responseText);
            });
        }

        function addPromosiField(judul = '', teks = '') {
            const wrapper = $('#promosiWrapper');
            const item = $(`
            <div class="promosi-item mb-3 border p-3 rounded">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <input type="text" class="form-control form-control-sm judul me-2" placeholder="Judul promosi" value="${judul}">
                    <button type="button" class="btn btn-sm btn-danger remove-promosi" title="Hapus promosi">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
                <textarea class="form-control teks" rows="2" placeholder="Isi promosi">${teks}</textarea>
            </div>
        `);
            wrapper.append(item);
        }

        $('#addPromosi').on('click', function() {
            addPromosiField();
        });

        $(document).on('click', '.remove-promosi', function() {
            $(this).closest('.promosi-item').remove();
        });

        $('#formPromosi').on('submit', function(e) {
            e.preventDefault();
            const promosi = [];

            $('#promosiWrapper .promosi-item').each(function() {
                const judul = $(this).find('.judul').val().trim();
                const teks = $(this).find('.teks').val().trim();
                if (judul) {
                    promosi.push({
                        judul,
                        teks
                    });
                }
            });

            $.ajax({
                url: '/konten/update',
                type: 'POST',
                data: {
                    halaman: 'beranda_promosi',
                    konten: JSON.stringify({
                        promosi
                    })
                },
                dataType: 'json',
                success: function(res) {
                    Swal.fire({
                        icon: res.status,
                        title: res.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                },
                error: function(xhr) {
                    console.error('Gagal menyimpan promosi:', xhr.responseText);
                    Swal.fire('Error', 'Gagal menyimpan promosi', 'error');
                }
            });
        });

        $('#formTeam').on('submit', function(e) {
            e.preventDefault();
            const team = [];
            $('#teamWrapper .team-member').each(function() {
                const nama = $(this).find('.nama').val();
                const jabatan = $(this).find('.jabatan').val();
                const foto = $(this).find('.foto').val();
                if (nama) team.push({
                    nama,
                    jabatan,
                    foto
                });
            });
            $.ajax({
                url: '/konten/update',
                type: 'POST',
                data: {
                    halaman: 'beranda_team',
                    konten: JSON.stringify({
                        team
                    })
                },
                dataType: 'json',
                success: function(res) {
                    Swal.fire({
                        icon: res.status,
                        title: res.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                },
                error: function(xhr) {
                    console.error('Gagal menyimpan konten team:', xhr.responseText);
                    Swal.fire('Error', 'Gagal menyimpan team', 'error');
                }
            });
        });

        $('#formSejarah').on('submit', function(e) {
            e.preventDefault();
            const konten = tinymce.get('editorSejarah').getContent();
            $.ajax({
                url: '/konten/update',
                type: 'POST',
                data: {
                    halaman: 'beranda_sejarah',
                    konten
                },
                dataType: 'json',
                success: function(res) {
                    Swal.fire({
                        icon: res.status,
                        title: res.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                },
                error: function(xhr) {
                    console.error('Gagal menyimpan konten sejarah:', xhr.responseText);
                    Swal.fire('Error', 'Gagal menyimpan konten sejarah', 'error');
                }
            });
        });

        $(document).ready(function() {
            loadKontenTeam();
            loadKontenPromosi();
        });
    </script>

</body>

</html>