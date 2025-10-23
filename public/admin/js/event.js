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
                        ? `../uploads/event/${ev.gambar_banner}`
                        : `../img/no-image.png`
                    }"
                    data-open-modal="true">
                    ${
                      ev.gambar_banner
                        ? `<img src="../uploads/event/${ev.gambar_banner}" class="card-img-top rounded-0" alt="${ev.nama_event}">`
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

        renderPagination(res.page, res.total_pages);
      },
      error: function () {
        Swal.fire("Error", "Gagal memuat data dari server.", "error");
      },
    });
  }

  function renderPagination(current, total) {
    renderPaginationGlobal("#pagination", current, total, function (page) {
      loadEvents(page);
    });
  }

  $("#pagination").on("click", ".page-link", function (e) {
    e.preventDefault();
    var page = $(this).data("page");
    if (page) {
      currentPage = page;
      loadEvents(currentPage);
    }
  });

  loadEvents();

  $("#btnAdd").click(function () {
    $("#eventForm")[0].reset();
    $("#id_event").val("");
    $("#eventModal").modal("show");
  });

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

  $("#eventContainer").on("click", ".btnEdit", function () {
    var id = $(this).data("id");

    $("#eventForm")[0].reset();
    $("#id_event").val(id);

    $("#bannerPreview").hide().attr("src", "");

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

          $("#nama_event").val(ev.nama_event);
          $("#tempat").val(ev.tempat);
          $("#tanggal").val(ev.tanggal);
          $("#waktu").val(ev.waktu);
          $("#deskripsi").val(ev.deskripsi);

          if (ev.gambar_banner) {
            $("#bannerPreview")
              .attr("src", "../uploads/event/" + ev.gambar_banner)
              .show();
          } else {
            $("#bannerPreview").hide();
          }

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

  $("#eventContainer").on("click", ".btnDelete", function () {
    var id = $(this).data("id");
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
          url: routeUrl + "/delete",
          type: "POST",
          data: {
            id_event: id,
          },
          dataType: "json",
          success: function (res) {
            if (res.status === "success") {
              Swal.fire("Sukses", res.message, "success");
              loadEvents();
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

  $("#eventContainer").on("click", ".btnDoc", function () {
    var id = $(this).data("id");
    $("#id_event").val(id);
    $("#docList").html('<p class="text-muted">Memuat dokumentasi...</p>');
    $("#docModal").modal("show");

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
            docs.forEach(function (doc) {
              list += `
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="position-relative dokumentasi-wrapper">
                        <input type="checkbox" class="doc-checkbox position-absolute top-0 start-0 m-1" data-id="${doc.id_dokumentasi}" data-event="${id}">
                        <img src="../uploads/event/${doc.gambar_dokumentasi}" class="dokumentasi-thumb img-fluid">
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

  $("#docList").on("change", ".doc-checkbox", function () {
    const anyChecked = $(".doc-checkbox:checked").length > 0;
    $("#btnDelSelected").prop("disabled", !anyChecked);
  });

  $("#btnSelectAll").on("click", function () {
    const allCheckboxes = $("#docList .doc-checkbox");

    if (allCheckboxes.length === 0) return;

    const allChecked =
      allCheckboxes.length === $(".doc-checkbox:checked").length;

    allCheckboxes.prop("checked", !allChecked);

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

  $("#docForm").submit(function (e) {
    e.preventDefault();
    var formData = new FormData(this);
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

  $("#btnAdd").click(function () {
    $("#eventForm")[0].reset();
    $("#id_event").val("");
    $("#bannerPreview").hide().attr("src", "");
    $("#eventModal").modal("show");
  });

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
                  <img src="../uploads/event/${doc.gambar_dokumentasi}" 
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

  function searchEvents(keyword) {
    if (keyword.trim() === "") {
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
                        ? `../uploads/event/${ev.gambar_banner}`
                        : `../img/no-image.png`
                    }"
                    data-open-modal="true">
                    ${
                      ev.gambar_banner
                        ? `<img src="../uploads/event/${ev.gambar_banner}" class="card-img-top rounded-0" alt="${ev.nama_event}">`
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

        $("#pagination").hide();
      },
      error: function () {
        Swal.fire("Error", "Gagal memuat hasil pencarian.", "error");
      },
    });
  }

  $(document).on("keyup", "#topbarInputIconLeft", function () {
    let keyword = $(this).val();
    searchEvents(keyword);
  });

  $(document).on("input", "#topbarInputIconLeft", function () {
    if ($(this).val().trim() === "") {
      $("#pagination").show();
      loadEvents(1);
    }
  });
});
