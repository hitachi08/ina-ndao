$(document).ready(function () {
  var routeUrl = "/event";
  var currentPage = 1;
  var limit = 6;

  function loadEvents(page = 1) {
    $.ajax({
      url: routeUrl + "/fetch_paginated",
      type: "GET",
      data: {
        page: page,
        limit: limit,
      },
      dataType: "json",
      success: function (res) {
        if (res.status !== "success") {
          Swal.fire("Error", res.message || "Gagal memuat data.", "error");
          return;
        }

        var events = res.data;
        var container = $("#eventContainer");
        container.empty();

        if (!events || events.length === 0) {
          container.html("<p class='text-muted'>Belum ada event.</p>");
          return;
        }

        events.forEach(function (ev) {
          var card = `
                                <div class="col-12 col-sm-6 col-md-4 col-lg-4 mb-4">
                                    <div class="card h-100 shadow-sm border-0 rounded-0 product-card cursor-pointer"
                                        data-id="${ev.id_event}"
                                        data-nama="${ev.nama_event}"
                                        data-deskripsi="${ev.deskripsi || ""}"
                                        data-tanggal="${ev.tanggal}"
                                        data-waktu="${ev.waktu}"
                                        data-tempat="${ev.tempat}"
                                        data-gambar="${
                                          ev.gambar_banner
                                            ? `../img/event/${ev.gambar_banner}`
                                            : `../img/no-image.png`
                                        }"
                                        data-open-modal="true">
                                        ${
                                          ev.gambar_banner
                                            ? `<img src="../img/event/${ev.gambar_banner}" class="card-img-top rounded-0" alt="${ev.nama_event}">`
                                            : `<img src="../img/no-image.png" class="card-img-top" alt="no image">`
                                        }
                                        <div class="card-body d-flex justify-content-between flex-column">
                                            <div> 
                                                <h6 class="card-title mb-1 text-truncate">${
                                                  ev.nama_event
                                                }</h6>
                                                <p class="card-text small mb-2 text-muted text-truncate2">${
                                                  ev.deskripsi || ""
                                                }</p>
                                            </div>
                                            <div class="small text-muted">
                                                <span class="d-block mb-1">
                                                    <i class="fa fa-calendar text-primary me-2"></i>${
                                                      ev.tanggal
                                                    }
                                                </span>
                                                <span class="d-block mb-1">
                                                    <i class="fa fa-clock text-primary me-2"></i>${
                                                      ev.waktu
                                                    }
                                                </span>
                                                <span class="d-block">
                                                    <i class="fa fa-map-marker-alt text-primary me-2"></i>${
                                                      ev.tempat
                                                    }
                                                </span>
                                            </div>
                                        </div>
                                        <div class="card-footer d-flex justify-content-between gap-2">
                                            <button class="btn btn-info btn-sm w-100 m-auto rounded-0 btnDoc" data-id="${
                                              ev.id_event
                                            }">Dokumentasi</button>
                                            <button class="btn btn-warning btn-sm w-100 m-auto rounded-0 btnEdit" data-id="${
                                              ev.id_event
                                            }">Edit</button>
                                            <button class="btn btn-danger btn-sm w-100 m-auto rounded-0 btnDelete" data-id="${
                                              ev.id_event
                                            }">Hapus</button>
                                        </div>
                                    </div>
                                </div>
                                `;
          container.append(card);
        });

        // 🔹 Pagination
        renderPagination(res.page, res.total_pages);
      },
      error: function () {
        Swal.fire("Error", "Gagal memuat data dari server.", "error");
      },
    });
  }

  function renderPagination(current, total) {
    var pagination = $("#pagination");
    pagination.empty();

    if (total <= 1) return;

    var maxVisible = 3;
    var start = Math.max(current - Math.floor(maxVisible / 2), 1);
    var end = Math.min(start + maxVisible - 1, total);
    start = Math.max(end - maxVisible + 1, 1);

    // Tombol First
    var firstDisabled = current === 1 ? "disabled" : "";
    pagination.append(`
                    <li class="page-item ${firstDisabled}">
                        <a class="page-link rounded-2" href="#" data-page="1">
                            <i class="bi bi-chevron-double-left"></i>
                        </a>
                    </li>
                `);

    // Tombol Prev
    var prevDisabled = current === 1 ? "disabled" : "";
    pagination.append(`
                    <li class="page-item ${prevDisabled}">
                        <a class="page-link rounded-2" href="#" data-page="${
                          current - 1
                        }">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    </li>
                `);

    // Jika start > 1, tampilkan "..."
    if (start > 1) {
      pagination.append(
        `<li class="page-item disabled"><span class="page-link rounded-2">...</span></li>`
      );
    }

    // Nomor halaman
    for (var i = start; i <= end; i++) {
      var active = i === current ? "active" : "";
      pagination.append(`
                    <li class="page-item ${active}">
                        <a class="page-link rounded-2" href="#" data-page="${i}">${i}</a>
                    </li>
                `);
    }

    // Jika end < total, tampilkan "..."
    if (end < total) {
      pagination.append(
        `<li class="page-item disabled"><span class="page-link rounded-2">...</span></li>`
      );
    }

    // Tombol Next
    var nextDisabled = current === total ? "disabled" : "";
    pagination.append(`
                    <li class="page-item ${nextDisabled}">
                        <a class="page-link rounded-2" href="#" data-page="${
                          current + 1
                        }">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                `);

    // Tombol Last
    var lastDisabled = current === total ? "disabled" : "";
    pagination.append(`
                    <li class="page-item ${lastDisabled}">
                        <a class="page-link rounded-2" href="#" data-page="${total}">
                            <i class="bi bi-chevron-double-right"></i>
                        </a>
                    </li>
                `);
  }

  // Klik pagination
  $("#pagination").on("click", ".page-link", function (e) {
    e.preventDefault();
    var page = $(this).data("page");
    if (page) {
      currentPage = page;
      loadEvents(currentPage);
    }
  });

  // Initial load
  loadEvents();

  // Tambah Event
  $("#btnAdd").click(function () {
    $("#eventForm")[0].reset();
    $("#id_event").val("");
    $("#eventModal").modal("show");
  });

  // Submit Form (Add/Edit)
  $("#eventForm").submit(function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    var action = $("#id_event").val() === "" ? "create" : "update";

    $.ajax({
      url: routeUrl + "/" + action,
      type: "POST",
      data: formData,
      dataType: "json",
      contentType: false,
      processData: false,
      success: function (res) {
        if (res.status === "success") {
          Swal.fire("Sukses", res.message, "success").then(() => {
            $("#eventModal").modal("hide");
            loadEvents();
          });
        } else {
          Swal.fire("Error", res.message || "Gagal menyimpan data.", "error");
        }
      },
      error: function () {
        Swal.fire("Error", "Gagal menyimpan data.", "error");
      },
    });
  });

  // Klik tombol Edit
  $("#eventContainer").on("click", ".btnEdit", function () {
    var id = $(this).data("id");

    // Reset form
    $("#eventForm")[0].reset();
    $("#id_event").val(id);

    // Reset preview
    $("#bannerPreview").hide().attr("src", "");

    // Ambil data event via AJAX
    $.ajax({
      url: routeUrl + "/fetch_single",
      type: "POST",
      data: {
        id_event: id,
      },
      dataType: "json",
      success: function (res) {
        if (res.status === "success" && res.data) {
          const ev = res.data;

          // Isi form
          $("#nama_event").val(ev.nama_event);
          $("#tempat").val(ev.tempat);
          $("#tanggal").val(ev.tanggal);
          $("#waktu").val(ev.waktu);
          $("#deskripsi").val(ev.deskripsi);

          // Tampilkan preview banner lama
          if (ev.gambar_banner) {
            $("#bannerPreview")
              .attr("src", "../img/event/" + ev.gambar_banner)
              .show();
          } else {
            $("#bannerPreview").hide();
          }

          // Tampilkan modal
          $("#eventModal").modal("show");
        } else {
          Swal.fire("Error", res.message || "Event tidak ditemukan", "error");
        }
      },
      error: function () {
        Swal.fire("Error", "Gagal mengambil data event.", "error");
      },
    });
  });

  // Update preview saat user pilih file baru
  $("#gambar_banner").on("change", function () {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        $("#bannerPreview").attr("src", e.target.result).show();
      };
      reader.readAsDataURL(file);
    } else {
      $("#bannerPreview").hide();
    }
  });

  // Klik tombol Hapus Event
  $("#eventContainer").on("click", ".btnDelete", function () {
    var id = $(this).data("id"); // ambil id_event
    Swal.fire({
      title: "Konfirmasi",
      text: "Apakah Anda yakin ingin menghapus event ini?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Ya, hapus!",
      cancelButtonText: "Batal",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: routeUrl + "/delete", // endpoint di controller
          type: "POST",
          data: {
            id_event: id,
          },
          dataType: "json",
          success: function (res) {
            if (res.status === "success") {
              Swal.fire("Sukses", res.message, "success");
              loadEvents(); // reload daftar event
            } else {
              Swal.fire("Error", res.message || "Gagal hapus event.", "error");
            }
          },
          error: function () {
            Swal.fire("Error", "Gagal menghubungi server.", "error");
          },
        });
      }
    });
  });

  // Klik tombol dokumentasi
  $("#eventContainer").on("click", ".btnDoc", function () {
    var id = $(this).data("id");
    $("#id_event").val(id);
    $("#docList").html('<p class="text-muted">Memuat dokumentasi...</p>');
    $("#docModal").modal("show");

    // Load dokumentasi event
    $.ajax({
      url: routeUrl + "/fetch_single",
      type: "POST",
      data: {
        id_event: id,
      },
      dataType: "json",
      success: function (res) {
        if (res.status === "success" && res.data) {
          var docs = res.data.dokumentasi || [];
          var list = "";
          if (docs.length > 0) {
            // Render dokumentasi dengan checkbox
            docs.forEach(function (doc) {
              list += `
                                    <div class="col-6 col-md-4 col-lg-3">
                                        <div class="position-relative dokumentasi-wrapper">
                                            <input type="checkbox" class="doc-checkbox position-absolute top-0 start-0 m-1" data-id="${doc.id_dokumentasi}" data-event="${id}">
                                            <img src="../img/event/${doc.gambar_dokumentasi}" class="dokumentasi-thumb img-fluid">
                                            <button class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 btnDelDoc" 
                                                    data-id="${doc.id_dokumentasi}" data-event="${id}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                `;
            });
          } else {
            list = "<p class='text-muted'>Belum ada dokumentasi.</p>";
          }
          $("#docList").html(list);
          $("#btnDelSelected").prop("disabled", true);
        }
      },
    });
  });

  // Enable/disable tombol "Hapus Terpilih" jika ada checkbox terpilih
  $("#docList").on("change", ".doc-checkbox", function () {
    const anyChecked = $(".doc-checkbox:checked").length > 0;
    $("#btnDelSelected").prop("disabled", !anyChecked);
  });

  // Tombol Pilih Semua
  $("#btnSelectAll").on("click", function () {
    const allCheckboxes = $("#docList .doc-checkbox");

    if (allCheckboxes.length === 0) return;

    const allChecked =
      allCheckboxes.length === $(".doc-checkbox:checked").length;

    // Jika semua sudah dicentang, klik lagi untuk uncheck semua
    allCheckboxes.prop("checked", !allChecked);

    // Update tombol hapus terpilih
    const anyChecked = $(".doc-checkbox:checked").length > 0;
    $("#btnDelSelected").prop("disabled", !anyChecked);
  });

  $("#btnDelSelected").on("click", function () {
    const selected = $(".doc-checkbox:checked")
      .map(function () {
        return $(this).data("id");
      })
      .get();

    if (selected.length === 0) return;

    Swal.fire({
      title: "Hapus dokumentasi terpilih?",
      text: `Akan menghapus ${selected.length} file dokumentasi.`,
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Ya, hapus",
      cancelButtonText: "Batal",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: routeUrl + "/delete_multiple_dokumentasi",
          type: "POST",
          data: {
            id_dokumentasi: selected,
          },
          dataType: "json",
          success: function (res) {
            if (res.status === "success") {
              Swal.fire("Sukses", res.message, "success");
              $("#docModal").modal("hide");
              loadEvents(currentPage);
            } else {
              Swal.fire("Error", res.message || "Gagal hapus.", "error");
            }
          },
        });
      }
    });
  });

  // Upload dokumentasi baru
  $("#docForm").submit(function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    // Tambahkan ID event secara eksplisit
    formData.append("id_event", $("#id_event").val());

    $.ajax({
      url: routeUrl + "/add_dokumentasi",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (res) {
        if (res.status === "success") {
          Swal.fire("Sukses", res.message, "success");
          $("#docModal").modal("hide");
          loadEvents(currentPage);
        } else {
          Swal.fire(
            "Error",
            res.message || "Gagal upload dokumentasi.",
            "error"
          );
        }
      },
    });
  });

  // Hapus dokumentasi
  $("#docList").on("click", ".btnDelDoc", function () {
    var id = $(this).data("id");
    var eventId = $(this).data("event");
    $.ajax({
      url: routeUrl + "/delete_dokumentasi",
      type: "POST",
      data: {
        id_event: eventId,
        id_dokumentasi: id,
      },
      dataType: "json",
      success: function (res) {
        if (res.status === "success") {
          Swal.fire("Sukses", res.message, "success");
          $("#docModal").modal("hide");
          loadEvents(currentPage);
        } else {
          Swal.fire(
            "Error",
            res.message || "Gagal hapus dokumentasi.",
            "error"
          );
        }
      },
    });
  });

  $("#docModal").on("hidden.bs.modal", function () {
    $("#docForm")[0].reset();
    $("#id_event").val("");
    $("#docList").html("");
  });

  // Tambah Event
  $("#btnAdd").click(function () {
    $("#eventForm")[0].reset();
    $("#id_event").val("");
    $("#bannerPreview").hide().attr("src", "");
    $("#eventModal").modal("show");
  });

  // Klik card untuk buka detail modal
  $(document).on("click", ".product-card", function (e) {
    if ($(e.target).closest("button").length) return;

    const card = $(this);
    const id_event = card.data("id");

    $("#detailNama").text(card.data("nama"));
    $("#detailDeskripsi").text(
      card.data("deskripsi") || "Tidak ada deskripsi."
    );
    $("#detailTanggal").text(card.data("tanggal"));
    $("#detailWaktu").text(card.data("waktu"));
    $("#detailTempat").text(card.data("tempat"));
    $("#detailGambar").attr("src", card.data("gambar"));
    $("#detailDokumentasi").html(
      '<p class="text-muted">Memuat dokumentasi...</p>'
    );

    $("#detailModal").modal("show");

    $.ajax({
      url: routeUrl + "/fetch_single",
      type: "POST",
      data: {
        id_event: id_event,
      },
      dataType: "json",
      success: function (res) {
        if (res.status === "success" && res.data) {
          const docs = res.data.dokumentasi || [];
          let html = "";

          if (docs.length > 0) {
            docs.forEach((doc) => {
              html += `
                            <div class="col-6 col-md-4 col-lg-3">
                                <img src="../img/event/${
                                  doc.gambar_dokumentasi
                                }" 
                                     class="img-fluid shadow-sm"
                                     style="width: 100px; height: 150px; object-fit: cover;" 
                                     alt="Dokumentasi ${card.data("nama")}">
                            </div>`;
            });
          } else {
            html = `<p class="text-muted fst-italic">Belum ada dokumentasi tersedia.</p>`;
          }

          $("#detailDokumentasi").html(html);
        } else {
          $("#detailDokumentasi").html(
            `<p class="text-muted fst-italic">Tidak ada dokumentasi ditemukan.</p>`
          );
        }
      },
      error: function () {
        $("#detailDokumentasi").html(
          `<p class="text-danger">Gagal memuat dokumentasi.</p>`
        );
      },
    });
  });

  // 🔍 Fungsi pencarian event
  function searchEvents(keyword) {
    if (keyword.trim() === "") {
      // jika kosong, kembali ke mode pagination biasa
      loadEvents(1);
      return;
    }

    $.ajax({
      url: routeUrl + "/search",
      type: "GET",
      data: {
        keyword: keyword,
      },
      dataType: "json",
      success: function (res) {
        if (res.status !== "success") {
          Swal.fire(
            "Error",
            res.message || "Gagal memuat hasil pencarian.",
            "error"
          );
          return;
        }

        var events = res.data;
        var container = $("#eventContainer");
        container.empty();

        if (!events || events.length === 0) {
          container.html(
            "<p class='text-muted'>Tidak ada event dengan kata kunci tersebut.</p>"
          );
          return;
        }

        // Render hasil pencarian sama seperti loadEvents
        events.forEach(function (ev) {
          var card = `
                                <div class="col-12 col-sm-6 col-md-4 col-lg-4 mb-4">
                                    <div class="card h-100 shadow-sm border-0 rounded-0 product-card cursor-pointer"
                                        data-id="${ev.id_event}"
                                        data-nama="${ev.nama_event}"
                                        data-deskripsi="${ev.deskripsi || ""}"
                                        data-tanggal="${ev.tanggal}"
                                        data-waktu="${ev.waktu}"
                                        data-tempat="${ev.tempat}"
                                        data-gambar="${
                                          ev.gambar_banner
                                            ? `../img/event/${ev.gambar_banner}`
                                            : `../img/no-image.png`
                                        }"
                                        data-open-modal="true">
                                        ${
                                          ev.gambar_banner
                                            ? `<img src="../img/event/${ev.gambar_banner}" class="card-img-top rounded-0" alt="${ev.nama_event}">`
                                            : `<img src="../img/no-image.png" class="card-img-top" alt="no image">`
                                        }
                                        <div class="card-body d-flex justify-content-between flex-column">
                                            <div> 
                                                <h6 class="card-title mb-1 text-truncate">${
                                                  ev.nama_event
                                                }</h6>
                                                <p class="card-text small mb-2 text-muted text-truncate2">${
                                                  ev.deskripsi || ""
                                                }</p>
                                            </div>
                                            <div class="small text-muted">
                                                <span class="d-block mb-1">
                                                    <i class="fa fa-calendar text-primary me-2"></i>${
                                                      ev.tanggal
                                                    }
                                                </span>
                                                <span class="d-block mb-1">
                                                    <i class="fa fa-clock text-primary me-2"></i>${
                                                      ev.waktu
                                                    }
                                                </span>
                                                <span class="d-block">
                                                    <i class="fa fa-map-marker-alt text-primary me-2"></i>${
                                                      ev.tempat
                                                    }
                                                </span>
                                            </div>
                                        </div>
                                        <div class="card-footer d-flex justify-content-between gap-2">
                                            <button class="btn btn-info btn-sm w-100 m-auto rounded-0 btnDoc" data-id="${
                                              ev.id_event
                                            }">Dokumentasi</button>
                                            <button class="btn btn-warning btn-sm w-100 m-auto rounded-0 btnEdit" data-id="${
                                              ev.id_event
                                            }">Edit</button>
                                            <button class="btn btn-danger btn-sm w-100 m-auto rounded-0 btnDelete" data-id="${
                                              ev.id_event
                                            }">Hapus</button>
                                        </div>
                                    </div>
                                </div>
                            `;
          container.append(card);
        });

        // Sembunyikan pagination saat pencarian
        $("#pagination").hide();
      },
      error: function () {
        Swal.fire("Error", "Gagal memuat hasil pencarian.", "error");
      },
    });
  }

  // 🔎 Event listener untuk input search di navbar
  $(document).on("keyup", "#topbarInputIconLeft", function () {
    let keyword = $(this).val();
    searchEvents(keyword);
  });

  // Tampilkan kembali pagination jika search dikosongkan
  $(document).on("input", "#topbarInputIconLeft", function () {
    if ($(this).val().trim() === "") {
      $("#pagination").show();
      loadEvents(1);
    }
  });
});
