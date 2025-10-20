$(document).ready(function () {
  const routeUrl = "/galeri";

  let currentPage = 1;
  const itemsPerPage = 8;
  let galeriData = [];

  function formatRupiah(angka) {
    angka = angka.replace(/[^,\d]/g, "").toString();
    let split = angka.split(",");
    let sisa = split[0].length % 3;
    let rupiah = split[0].substr(0, sisa);
    let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
      let separator = sisa ? "." : "";
      rupiah += separator + ribuan.join(".");
    }

    return "Rp " + rupiah;
  }

  function parseRupiah(rupiahStr) {
    return rupiahStr.replace(/[^0-9]/g, "");
  }

  $("#harga").on("focus", function () {
    if ($(this).val().trim() === "" || $(this).val().trim() === "Rp") {
      $(this).val("Rp ");
    }
  });

  $("#harga").on("input", function () {
    let value = $(this)
      .val()
      .replace(/^Rp\s?/, "");
    $(this).val(formatRupiah(value));
  });

  $("#galeriForm").on("submit", function () {
    const raw = $("#harga").val();
    const numeric = parseRupiah(raw);
    $("#harga").val(numeric);
  });

  function loadGaleri(page = 1) {
    $.ajax({
      url: `${routeUrl}/fetch_all`,
      type: "GET",
      dataType: "json",
      success: function (res) {
        galeriData = res.data || [];
        renderGaleriPage(page);
        renderPagination(galeriData.length, page);
      },
      error: function (xhr) {
        Swal.fire("Error", "Gagal memuat galeri: " + xhr.responseText, "error");
      },
    });
  }

  $("#topbarInputIconLeft").on("keyup", function () {
    const keyword = $(this).val().trim();

    if (keyword.length === 0) {
      loadGaleri();
      return;
    }

    $.ajax({
      url: `${routeUrl}/search`,
      type: "GET",
      data: { q: keyword },
      dataType: "json",
      success: function (res) {
        galeriData = res.data || [];
        currentPage = 1;
        renderGaleriPage(currentPage);
        renderPagination(galeriData.length, currentPage);
      },
      error: function (xhr) {
        console.error("Pencarian gagal:", xhr.responseText);
      },
    });
  });

  function renderGaleriPage(page) {
    const container = $("#galeriContainer");
    container.empty();

    if (!galeriData.length) {
      container.html('<p class="text-muted">Belum ada motif.</p>');
      return;
    }

    const start = (page - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    const pageData = galeriData.slice(start, end);

    pageData.forEach((item) => {
      const gambarUtama =
        item.motif_gambar && item.motif_gambar.length > 0
          ? item.motif_gambar[0].path_gambar
          : "/img/no-image.png";

      const card = `
      <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
        <div class="card h-100 border-0 shadow-sm rounded-0 overflow-hidden product-card position-relative">
          <img src="${gambarUtama}" 
              class="card-img-top img-fluid rounded-0 detail-image"
              alt="${item.nama_motif}"
              data-nama="${item.nama_motif}"
              data-cerita="${item.makna || ""}"
              data-gambar='${JSON.stringify(item.motif_gambar)}'
              style="height: 220px; object-fit: cover; transition: transform .3s ease;">
  
          <div class="card-body d-flex flex-column px-3">
            <div class="fw-bold text-dark mb-1 text-truncate">
              ${
                item.nama_jenis && item.nama_daerah
                  ? `${item.nama_jenis} ${item.nama_daerah}`
                  : item.nama_jenis || item.nama_daerah || "-"
              }
            </div>
            <div class="text-muted d-block mb-2">Motif ${item.nama_motif}</div>
            <div class="small text-secondary flex-grow-1 text-truncate2 mb-3">
              ${item.makna || ""}
            </div>
            <div class="mb-3">
              <div class="fw-semibold text-primary" style="font-size: 1.05rem;">
                ${formatRupiah(Math.floor(parseFloat(item.harga)).toString())}
              </div>
              <div class="small text-muted" style="font-size: 0.7rem;">
                ${Math.round(item.panjang_cm)} × ${Math.round(
        item.lebar_cm
      )} cm • ${item.bahan || "-"}
              </div>
              <div class="small text-muted">Stok: ${item.stok}</div>
            </div>
            <div class="d-flex gap-2">
              <button class="btn btn-sm btn-outline-warning w-50 rounded-pill btnEdit" data-id="${
                item.id_kain
              }">
                <i class="bi bi-pencil"></i> Edit
              </button>
              <button class="btn btn-sm btn-outline-danger w-50 rounded-pill btnDelete" data-id="${
                item.id_kain
              }">
                <i class="bi bi-trash"></i> Hapus
              </button>
            </div>
          </div>
        </div>
      </div>`;
      container.append(card);
    });
  }

  function renderPagination(totalItems, currentPage) {
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    const pagination = $("#pagination");
    pagination.empty();

    if (totalPages <= 1) return;

    const createPageItem = (
      labelHtml,
      page,
      disabled = false,
      active = false
    ) => {
      return `
      <li class="page-item ${disabled ? "disabled" : ""} ${
        active ? "active" : ""
      }">
        <a class="page-link rounded-2" href="#" data-page="${page}">
          ${labelHtml}
        </a>
      </li>`;
    };

    pagination.append(
      createPageItem(
        `<i class="bi bi-chevron-double-left"></i>`,
        1,
        currentPage === 1
      )
    );
    pagination.append(
      createPageItem(
        `<i class="bi bi-chevron-left"></i>`,
        currentPage - 1,
        currentPage === 1
      )
    );

    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalPages, currentPage + 2);

    if (startPage > 1) {
      pagination.append(
        `<li class="page-item disabled"><span class="page-link">...</span></li>`
      );
    }

    for (let i = startPage; i <= endPage; i++) {
      pagination.append(createPageItem(i, i, false, i === currentPage));
    }

    if (endPage < totalPages) {
      pagination.append(
        `<li class="page-item disabled"><span class="page-link">...</span></li>`
      );
    }

    pagination.append(
      createPageItem(
        `<i class="bi bi-chevron-right"></i>`,
        currentPage + 1,
        currentPage === totalPages
      )
    );
    pagination.append(
      createPageItem(
        `<i class="bi bi-chevron-double-right"></i>`,
        totalPages,
        currentPage === totalPages
      )
    );

    pagination.find("a").on("click", function (e) {
      e.preventDefault();
      const targetPage = parseInt($(this).data("page"));
      if (targetPage && targetPage !== currentPage) {
        currentPage = targetPage;
        renderGaleriPage(currentPage);
        renderPagination(totalItems, currentPage);
        window.scrollTo({ top: 0, behavior: "smooth" });
      }
    });
  }

  function loadSelectOptions(callback) {
    $.ajax({
      url: `${routeUrl}/get_options`,
      type: "GET",
      dataType: "json",
      success: function (res) {
        if (res.status === "success") {
          initSelect2(res);
          if (callback) callback();
        } else {
          console.error("Gagal load options:", res.message);
        }
      },
      error: function (xhr) {
        console.error("Gagal load options:", xhr.responseText);
      },
    });
  }

  function initSelect2(res) {
    const selectConfig = {
      placeholder: "Pilih atau ketik",
      tags: true,
      width: "100%",
      dropdownParent: $("#galeriModal"),
    };

    $("#nama_jenis")
      .empty()
      .select2({
        ...selectConfig,
        data: res.jenis.map((j) => ({
          id: j.id_jenis_kain,
          text: j.nama_jenis,
        })),
      });
    $("#nama_daerah")
      .empty()
      .select2({
        ...selectConfig,
        data: res.daerah.map((d) => ({
          id: d.id_daerah,
          text: d.nama_daerah,
        })),
      });
    $("#nama_motif")
      .empty()
      .select2({
        ...selectConfig,
        data: res.motif.map((m) => ({
          id: m.id_motif,
          text: m.nama_motif,
        })),
      });
  }

  function previewImages(input, previewContainer) {
    const files = input.files;
    $(previewContainer).empty();

    if (files) {
      Array.from(files).forEach((file) => {
        const reader = new FileReader();
        reader.onload = function (e) {
          const img = $("<img>")
            .attr("src", e.target.result)
            .addClass("img-thumbnail me-2 mb-2")
            .css({
              width: "200px",
              height: "200px",
              objectFit: "cover",
            });
          $(previewContainer).append(img);
        };
        reader.readAsDataURL(file);
      });
    }
  }

  $("#gambar").on("change", function () {
    previewImages(this, "#previewGambar");
  });

  function setEditPreview(existingImages) {
    const container = $("#previewGambar");
    container.empty();

    if (existingImages && existingImages.length > 0) {
      existingImages.forEach((img) => {
        const imageEl = $("<img>")
          .attr("src", img.path_gambar)
          .addClass("img-thumbnail me-2 mb-2")
          .css({
            width: "200px",
            height: "200px",
            objectFit: "cover",
          });
        container.append(imageEl);
      });
    }
  }

  $("#btnAdd").click(function () {
    $("#galeriForm")[0].reset();
    $("#id_variasi").val("");
    $("#previewGambar").empty();
    $("#gambar").val("");
    const galeriModal = new bootstrap.Modal(
      document.getElementById("galeriModal")
    );
    galeriModal.show();
    loadSelectOptions();
  });

  $("#galeriForm").submit(function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    const action = $("#id_variasi").val() ? "update_kain" : "add_kain";

    $.ajax({
      url: `${routeUrl}/${action}`,
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (res) {
        if (res.status === "success") {
          Swal.fire("Sukses", res.message, "success").then(() =>
            loadGaleri(currentPage)
          );
          const galeriModalEl = document.getElementById("galeriModal");
          bootstrap.Modal.getInstance(galeriModalEl).hide();
        } else {
          Swal.fire("Error", res.message, "error");
        }
      },
      error: function (xhr) {
        Swal.fire(
          "Error",
          "Gagal menyimpan data: " + xhr.responseText,
          "error"
        );
      },
    });
  });

  $("#galeriContainer").on("click", ".btnEdit", function () {
    const id = $(this).data("id");
    const galeriModal = new bootstrap.Modal(
      document.getElementById("galeriModal")
    );
    galeriModal.show();
    $("#galeriForm")[0].reset();
    $("#gambar").val("");

    loadSelectOptions(() => {
      $.ajax({
        url: `${routeUrl}/fetch_single`,
        type: "POST",
        data: { id_kain: id },
        dataType: "json",
        success: function (res) {
          if (res.status === "success") {
            const data = res.data;
            $("#id_variasi").val(data.id_kain);
            $("#nama_jenis").val(data.id_jenis_kain).trigger("change");
            $("#nama_daerah").val(data.id_daerah).trigger("change");
            $("#nama_motif").val(data.id_motif).trigger("change");
            $("#cerita").val(data.makna || "");
            $("#bahan").val(data.bahan);
            $("#jenis_pewarna").val(data.jenis_pewarna);
            $("#harga").val("Rp " + Number(data.harga).toLocaleString("id-ID"));
            $("#stok").val(data.stok);
            $("#panjang").val(parseInt(data.panjang_cm));
            $("#lebar").val(parseInt(data.lebar_cm));
            setEditPreview(data.motif_gambar);
          } else {
            Swal.fire("Error", res.message, "error");
          }
        },
      });
    });
  });

  $("#galeriContainer").on("click", ".btnDelete", function () {
    const id = $(this).data("id");
    Swal.fire({
      title: "Yakin ingin menghapus?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Ya, hapus!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: `${routeUrl}/delete_kain`,
          type: "POST",
          data: { id_kain: id },
          dataType: "json",
          success: function (res) {
            if (res.status === "success") {
              Swal.fire("Sukses", res.message, "success").then(() =>
                loadGaleri(currentPage)
              );
            } else {
              Swal.fire("Error", res.message, "error");
            }
          },
          error: function (xhr) {
            Swal.fire(
              "Error",
              "Gagal menghapus data: " + xhr.responseText,
              "error"
            );
          },
        });
      }
    });
  });

  $("#galeriContainer").on("click", ".detail-image", function (e) {
    e.stopPropagation();
    const nama = $(this).data("nama");
    const cerita = $(this).data("cerita");
    const gambar = $(this).data("gambar");

    $("#detailMotifTitle").text("Motif " + nama);
    $("#detailMotifStoryTitle").text(
      `CERITA LENGKAP DIBALIK MOTIF ${nama.toUpperCase()}`
    );
    const imagesContainer = $("#detailMotifImages");
    imagesContainer.empty();

    if (gambar && gambar.length > 0) {
      gambar.forEach((img) => {
        imagesContainer.append(`
      <div class="col-6 d-flex justify-content-center">
        <img src="${img.path_gambar}" class="img-thumbnail detail-image-modal" style="width: 100%; max-width: 250px; height: auto; cursor: auto;">
      </div>
    `);
      });
    } else {
      imagesContainer.append(`
    <div class="col-12 text-center">
      <img src="/img/no-image.png" class="detail-image-modal img-thumbnail" style="max-width: 250px; cursor: auto;">
    </div>
  `);
    }

    $("#detailMotifCerita").text(cerita || "");
    const detailModal = new bootstrap.Modal(
      document.getElementById("detailMotifModal")
    );
    detailModal.show();
  });

  loadGaleri();
});
