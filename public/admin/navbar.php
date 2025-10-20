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
            </div>

            <ul class="navbar-nav align-items-center">

                <li class="nav-item nav-item-notif dropdown me-2">
                    <a class="nav-link text-dark dropdown-toggle p-0" id="notifDropdownBtn" href="#" role="button"
                        data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                        <svg class="icon text-gray-900" fill="currentColor" style="height: 1.7rem;" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z">
                            </path>
                        </svg>
                        <span id="notifBadge" class="position-absolute translate-middle badge rounded-pill bg-danger d-none badge-notif">0</span>
                    </a>

                    <div class="dropdown-menu drop-menu-notif dropdown-menu-lg dropdown-menu-center mt-2 py-0" style="left: -18px">
                        <div class="list-group list-group-flush" id="notifList">
                            <div class="text-center py-3 text-primary fw-bold border-bottom">Notifikasi</div>
                            <div class="text-center py-3 text-muted" id="notifLoading">Memuat notifikasi...</div>
                        </div>
                        <div class="dropdown-divider m-0"></div>
                        <div class="p-2 text-center">
                            <button id="markAllRead" class="btn btn-sm btn-outline-secondary">Tandai semua dibaca</button>
                            <a href="/admin/event" class="btn btn-sm btn-primary ms-2">Lihat Semua</a>
                        </div>
                    </div>
                </li>

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

<div class="modal fade" id="allNotifModal" tabindex="-1" aria-labelledby="allNotifModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="allNotifModalLabel">Seluruh Notifikasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="list-group list-group-flush" id="allNotifList">
                    <div class="text-center py-3 text-muted" id="allNotifLoading">Memuat notifikasi...</div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="markAllReadModal" class="btn btn-sm btn-outline-secondary">Tandai semua dibaca</button>
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script src="../js/jquery.min.js"></script>

<style>
    .bg-light-read {
        background-color: #e9ecef !important;
        color: #6c757d !important;
    }
</style>
<script>
    $(function() {
        const apiBase = '/notifications';
        let showingAll = false;

        function renderNotifications(data) {
            const list = $('#notifList');
            list.find('#notifLoading').remove();
            list.find('.notif-item').remove();
            list.find('#showAllNotifContainer').remove();

            if (!data.length) {
                list.append('<div class="text-center py-3 text-muted notif-item">Tidak ada notifikasi</div>');
                return;
            }

            const unread = data.filter(n => n.dibaca == 0);
            const read = data.filter(n => n.dibaca != 0);

            let displayData = [];
            if (showingAll) {
                displayData = [...unread, ...read];
            } else {
                let remaining = 3;
                for (let i = 0; i < unread.length && remaining > 0; i++, remaining--) displayData.push(unread[i]);
                for (let i = 0; i < read.length && remaining > 0; i++, remaining--) displayData.push(read[i]);
            }

            displayData.forEach(n => {
                const time = new Date(n.created_at).toLocaleString();
                const isUnread = n.dibaca == 0;
                const bgClass = isUnread ? 'bg-light' : 'bg-light-read';

                const item = $(`
            <a href="#" class="list-group-item list-group-item-action notif-item ${bgClass}" 
               data-id="${n.id}" data-ref="${n.referensi}">
              <div class="d-flex justify-content-between align-items-center">
                <div class="fw-semibold">${escapeHtml(n.judul)}</div>
                <small class="text-muted">${time}</small>
              </div>
              <div class="small text-muted">${escapeHtml(n.isi)}</div>
            </a>
        `);
                list.append(item);
            });

            if (!showingAll && data.length > 3) {
                list.append(`
            <div id="showAllNotifContainer" class="text-center py-2 border-top">
                <button id="showAllNotif" class="btn btn-sm text-primary w-100">
                    Lihat seluruh notifikasi
                </button>
            </div>
        `);
            }
        }

        function loadNotifications() {
            const url = showingAll ? apiBase + '/all' : apiBase + '/list';
            fetch(url)
                .then(r => r.json())
                .then(res => {
                    if (res.status === 'ok') renderNotifications(res.data);
                })
                .catch(err => console.error('Load notifications error', err));
        }

        function loadAllNotificationsModal() {
            const list = $('#allNotifList');
            list.find('.notif-item').remove();
            list.find('#allNotifLoading').show();

            fetch(apiBase + '/all')
                .then(r => r.json())
                .then(res => {
                    list.find('#allNotifLoading').hide();
                    if (res.status !== 'ok' || !res.data.length) {
                        list.append('<div class="text-center py-3 text-muted notif-item">Tidak ada notifikasi</div>');
                        return;
                    }

                    const unread = res.data.filter(n => n.dibaca == 0);
                    const read = res.data.filter(n => n.dibaca != 0);
                    const displayData = [...unread, ...read];

                    displayData.forEach(n => {
                        const time = new Date(n.created_at).toLocaleString();
                        const isUnread = n.dibaca == 0;
                        const bgClass = isUnread ? 'bg-light' : 'bg-light-read';

                        const item = $(`
                    <a href="#" class="list-group-item list-group-item-action notif-item ${bgClass}" 
                       data-id="${n.id}" data-ref="${n.referensi}">
                      <div class="d-flex justify-content-between align-items-center">
                        <div class="fw-semibold">${escapeHtml(n.judul)}</div>
                        <small class="text-muted">${time}</small>
                      </div>
                      <div class="small text-muted">${escapeHtml(n.isi)}</div>
                    </a>
                `);

                        list.append(item);
                    });
                })
                .catch(err => console.error('Load all notifications error', err));
        }

        function loadUnreadBadge() {
            fetch(apiBase + '/unreadcount')
                .then(r => r.json())
                .then(res => {
                    if (res.status === 'ok') {
                        const c = res.count;
                        $('#notifBadge').toggleClass('d-none', c === 0).text(c);
                    }
                });
        }

        function escapeHtml(text) {
            return $('<div>').text(text).html();
        }

        loadNotifications();
        loadUnreadBadge();
        setInterval(() => {
            loadNotifications();
            loadUnreadBadge();
        }, 60000);

        $('#notifList').on('click', '.notif-item', function(e) {
            e.preventDefault();
            const $this = $(this);
            const id = $this.data('id');
            const ref = $this.data('ref');

            $this.removeClass('bg-light').addClass('bg-light-read');

            fetch(apiBase + '/markread', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    id
                })
            }).then(() => {
                loadUnreadBadge();
                loadNotifications();

                if (ref && ref.startsWith('event:')) {
                    const eid = ref.split(':')[1];
                    window.location.href = '/event/detail/' + eid;
                }
            });
        });

        $('#markAllRead').on('click', function() {
            fetch(apiBase + '/markall', {
                    method: 'POST'
                })
                .then(r => r.json())
                .then(res => {
                    if (res.status === 'ok') {
                        loadNotifications();
                        loadUnreadBadge();
                    }
                });
        });

        $('#notifDropdownBtn').closest('.nav-item').on('show.bs.dropdown', function() {
            showingAll = false;
            loadNotifications();
            loadUnreadBadge();
        });

        $('#notifList').on('click', '#showAllNotif', function() {
            const modal = new bootstrap.Modal(document.getElementById('allNotifModal'));
            modal.show();

            loadAllNotificationsModal();
            showingAll = true;
            loadNotifications();
            loadUnreadBadge();
        });

        $('#allNotifList').on('click', '.notif-item', function(e) {
            e.preventDefault();
            const $this = $(this);
            const id = $this.data('id');
            const ref = $this.data('ref');

            $this.removeClass('bg-light').addClass('bg-light-read');

            fetch(apiBase + '/markread', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    id
                })
            }).then(() => {
                loadUnreadBadge();
                loadAllNotificationsModal();
                if (ref && ref.startsWith('event:')) {
                    const eid = ref.split(':')[1];
                    window.location.href = '/event/detail/' + eid;
                }
            });
        });

        $('#markAllReadModal').on('click', function() {
            fetch(apiBase + '/markall', {
                    method: 'POST'
                })
                .then(r => r.json())
                .then(res => {
                    if (res.status === 'ok') {
                        loadUnreadBadge();
                        loadAllNotificationsModal();
                        loadNotifications();
                    }
                });
        });

    });
</script>
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