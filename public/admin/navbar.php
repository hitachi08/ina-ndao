<?php
$photo = $_SESSION['admin_photo'] ?? null;
$photoPath = $photo && file_exists(__DIR__ . "/../uploads/admin/$photo")
    ? "/uploads/admin/$photo"
    : "/img/default-user.png";
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />

<nav class="navbar navbar-top navbar-expand navbar-dashboard navbar-dark ps-0 pe-2 pb-0">
    <div class="container-fluid px-0">
        <div class="d-flex justify-content-between w-100" id="navbarSupportedContent">
            <div class="d-flex align-items-center">
                <!-- Form Pencarian -->
                <form class="navbar-search form-inline" id="navbar-search-main">
                    <div class="input-group input-group-merge search-bar">
                        <span class="input-group-text" id="topbar-addon">
                            <svg class="icon icon-xs" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                        <input type="text" class="form-control" id="topbarInputIconLeft" placeholder="Cari..." aria-label="Cari"
                            aria-describedby="topbar-addon">
                    </div>
                </form>
                <!-- /Form Pencarian -->
            </div>

            <!-- Navbar Links -->
            <ul class="navbar-nav align-items-center">

                <!-- Notifikasi -->
                <li class="nav-item dropdown">
                    <a class="nav-link text-dark notification-bell unread dropdown-toggle" href="#" role="button"
                        data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                        <svg class="icon icon-sm text-gray-900" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z">
                            </path>
                        </svg>
                    </a>

                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-center mt-2 py-0" style="left: -15px;">
                        <div class="list-group list-group-flush">
                            <a href="#" class="text-center text-primary fw-bold border-bottom border-light py-3">
                                Notifikasi Terbaru
                            </a>

                            <a href="#" class="list-group-item list-group-item-action border-bottom">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                    </div>
                                    <div class="col ps-0 ms-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h4 class="h6 mb-0 text-small">Pameran Tenun NTT</h4>
                                            </div>
                                            <div class="text-end">
                                                <small class="text-danger">5 menit lalu</small>
                                            </div>
                                        </div>
                                        <p class="font-small mt-1 mb-0">Event “Pameran Tenun Ina Ndao 2025” akan dimulai besok pukul
                                            09.00.</p>
                                    </div>
                                </div>
                            </a>

                            <a href="#" class="list-group-item list-group-item-action border-bottom">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                    </div>
                                    <div class="col ps-0 ms-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h4 class="h6 mb-0 text-small">Produk Baru</h4>
                                            </div>
                                            <div class="text-end">
                                                <small class="text-muted">1 jam lalu</small>
                                            </div>
                                        </div>
                                        <p class="font-small mt-1 mb-0">Produk baru “Selendang Motif Rote” telah ditambahkan ke katalog.
                                        </p>
                                    </div>
                                </div>
                            </a>

                            <a href="#" class="list-group-item list-group-item-action border-bottom">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                    </div>
                                    <div class="col ps-0 ms-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h4 class="h6 mb-0 text-small">Artikel Budaya</h4>
                                            </div>
                                            <div class="text-end">
                                                <small>2 jam lalu</small>
                                            </div>
                                        </div>
                                        <p class="font-small mt-1 mb-0">Artikel baru: “Makna Filosofis Tenun Ikat Ina Ndao”.</p>
                                    </div>
                                </div>
                            </a>

                            <a href="#" class="dropdown-item text-center fw-bold rounded-bottom py-3">
                                <svg class="icon icon-xxs text-gray-400 me-1" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                    <path fill-rule="evenodd"
                                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Lihat semua notifikasi
                            </a>
                        </div>
                    </div>
                </li>

                <!-- Pengaturan / User -->
                <li class="nav-item dropdown ms-lg-3">
                    <a class="nav-link dropdown-toggle pt-1 px-0" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <div class="media d-flex align-items-center">
                            <img class="avatar rounded-circle" src="<?= $photoPath ?>" alt="Foto Pengguna" style="object-fit: cover;">
                            <div class="media-body ms-2 text-dark align-items-center d-none d-lg-block">
                                <span class="mb-0 font-small fw-bold text-gray-900">
                                    <?php echo htmlspecialchars($username); ?>
                                </span>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-end mt-2 py-1">
                        <a class="dropdown-item d-flex align-items-center" href="#" id="btnEditProfile">
                            <svg class="dropdown-icon text-gray-400 me-2" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Profil Saya
                        </a>

                        <div role="separator" class="dropdown-divider my-1"></div>
                        <a class="dropdown-item d-flex align-items-center text-danger" href="logout.php">
                            <svg class="dropdown-icon text-danger me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                </path>
                            </svg>
                            Keluar
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Core -->
<script src="../js/sweetalert2.all.min.js"></script>

<script>
    document.getElementById('btnEditProfile').addEventListener('click', function(e) {
        e.preventDefault();

        fetch('/admin/pengaturan/getprofile')
            .then(async response => {
                const rawText = await response.text();
                return JSON.parse(rawText);
            })
            .then(data => {
                const photoUrl = data.photo ? `/uploads/admin/${data.photo}` : '/img/default-user.png';

                Swal.fire({
                    title: '<h3 class="fw-bold mb-2">Edit Profil Admin</h3>',
                    html: `
                <div class="text-start m-3">
                    <div class="text-center mb-3">
                        <img id="sw_preview" src="${photoUrl}" class="rounded-circle border shadow-sm" 
                             alt="Preview Foto" style="width:100px;height:100px;object-fit:cover;">
                        <div class="mt-2">
                            <label class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-upload"></i> Ganti Foto
                                <input type="file" id="sw_photo" accept="image/*" hidden>
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Username</label>
                        <input id="sw_username" type="text" class="form-control" 
                               value="${data.username ?? ''}" placeholder="Masukkan username">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input id="sw_email" type="email" class="form-control" 
                               value="${data.email ?? ''}" placeholder="Masukkan email aktif">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kata Sandi Baru</label>
                        <div class="input-group">
                            <input id="sw_password" type="password" class="form-control" 
                                   placeholder="Kosongkan jika tidak diubah">
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
                `,
                    showCancelButton: true,
                    confirmButtonText: '<i class="bi bi-save me-1"></i> Simpan Perubahan',
                    cancelButtonText: '<i class="bi bi-x-circle me-1"></i> Batal',
                    customClass: {
                        confirmButton: 'btn btn-primary px-4',
                        cancelButton: 'btn btn-secondary px-4 ms-2'
                    },
                    buttonsStyling: false,
                    focusConfirm: false,
                    didOpen: () => {
                        const toggleBtn = document.getElementById('togglePassword');
                        const inputPass = document.getElementById('sw_password');
                        toggleBtn.addEventListener('click', () => {
                            const type = inputPass.type === 'password' ? 'text' : 'password';
                            inputPass.type = type;
                            toggleBtn.innerHTML = type === 'password' ?
                                '<i class="bi bi-eye"></i>' :
                                '<i class="bi bi-eye-slash"></i>';
                        });

                        // 🖼️ Preview Foto
                        document.getElementById('sw_photo').addEventListener('change', function() {
                            const file = this.files[0];
                            if (file) {
                                const reader = new FileReader();
                                reader.onload = e => {
                                    document.getElementById('sw_preview').src = e.target.result;
                                };
                                reader.readAsDataURL(file);
                            }
                        });
                    },
                    preConfirm: () => {
                        const username = document.getElementById('sw_username').value.trim();
                        const email = document.getElementById('sw_email').value.trim();
                        const password = document.getElementById('sw_password').value.trim();
                        const photoFile = document.getElementById('sw_photo').files[0];

                        if (!username || !email) {
                            Swal.showValidationMessage('⚠️ Username dan Email wajib diisi');
                            return false;
                        }

                        return {
                            username,
                            email,
                            password,
                            photoFile
                        };
                    }
                }).then((result) => {
                    if (!result.isConfirmed) return;

                    const {
                        username,
                        email,
                        password,
                        photoFile
                    } = result.value;

                    // 🔄 Update profil (username dan email)
                    fetch('/admin/pengaturan/updateprofile', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: new URLSearchParams({
                                username,
                                email
                            })
                        })
                        .then(res => res.json())
                        .then(async res => {
                            if (!res.success) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: res.error || 'Tidak dapat memperbarui profil.',
                                    confirmButtonText: 'OK',
                                    customClass: {
                                        confirmButton: 'btn btn-danger px-4'
                                    },
                                    buttonsStyling: false
                                });
                                return;
                            }

                            // 🧩 Update password jika diisi
                            if (password) {
                                await fetch('/admin/pengaturan/updatepassword', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded'
                                    },
                                    body: new URLSearchParams({
                                        new_password: password
                                    })
                                });
                            }

                            // 🖼️ Upload foto jika ada file baru
                            if (photoFile) {
                                const formData = new FormData();
                                formData.append('photo', photoFile);
                                await fetch('/admin/pengaturan/updatephoto', {
                                        method: 'POST',
                                        body: formData
                                    })
                                    .then(res => res.json())
                                    .then(r => {
                                        if (r.success && r.photo) {
                                            const navbarImg = document.querySelector('.avatar');
                                            navbarImg.src = `/uploads/admin/${r.photo}`;
                                        }
                                    });
                            }

                            // ✅ Notifikasi sukses
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Profil berhasil diperbarui.',
                                confirmButtonText: 'OK',
                                customClass: {
                                    confirmButton: 'btn btn-success px-4'
                                },
                                buttonsStyling: false
                            }).then(() => {
                                document.querySelector('.media-body span').textContent = username;
                            });
                        })
                        .catch(err => {
                            console.error('❌ Error updateProfile:', err);
                            Swal.fire('Error', 'Terjadi kesalahan saat memperbarui profil', 'error');
                        });
                });
            })
            .catch(err => {
                console.error('❌ Fetch error (getProfile):', err);
                Swal.fire('Error', 'Tidak dapat memuat profil admin', 'error');
            });
    });
</script>