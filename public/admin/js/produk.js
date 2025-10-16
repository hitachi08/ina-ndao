$(document).ready(function () {
  const routeUrl = "/produk";
  let produkData = [];
  let currentPage = 1;
  const itemsPerPage = 8;

  // =========================
  // FORMAT RUPIAH
  // =========================
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
    if ($(this).val().trim() === "" || $(this).val().trim() === "Rp")
      $(this).val("Rp ");
  });

  $("#harga").on("input", function () {
    let value = $(this)
      .val()
      .replace(/^Rp\s?/, "");
    $(this).val(formatRupiah(value));
  });

  // =========================
  let allSubKategori = []; // variabel global untuk simpan semua sub_kategori

  function loadOptions() {
    $.ajax({
      url: "/produk/get_options",
      type: "GET",
      dataType: "json",
      success: function (res) {
        console.log("Response dari server:", res);

        if (res.status === "success") {
          const { kategori, sub_kategori, kain } = res.data;
          allSubKategori = sub_kategori; // simpan untuk filter nanti

          // ====== ISI DROPDOWN KATEGORI ======
          $("#id_kategori").html('<option value="">Pilih Kategori</option>');
          kategori.forEach((k) => {
            $("#id_kategori").append(
              `<option value="${k.id_kategori}">${k.nama_kategori}</option>`
            );
          });

          // ====== ISI DROPDOWN SUB KATEGORI (awal: kosong) ======
          $("#id_sub_kategori").html(
            '<option value="">Pilih Sub Kategori</option>'
          );

          // ====== ISI DROPDOWN KAIN ======
          $("#id_kain").html('<option value="">Pilih Kain</option>');
          kain.forEach((k) => {
            $("#id_kain").append(
              `<option value="${k.id_kain}">${k.nama_kain}</option>`
            );
          });

          // ====== SELECT2 SETUP ======
          // Kategori & Sub Kategori → bisa ketik baru
          $("#id_kategori, #id_sub_kategori").select2({
            dropdownParent: $("#produkModal"),
            tags: true,
            width: "100%",
            placeholder: "Pilih atau ketik...",
            createTag: function (params) {
              var term = $.trim(params.term);
              if (term === "") return null;
              return { id: term, text: term, newTag: true };
            },
          });

          // Kain → hanya bisa pilih
          $("#id_kain").select2({
            dropdownParent: $("#produkModal"),
            tags: false,
            width: "100%",
            placeholder: "Pilih kain...",
          });
        } else {
          console.error("Error dari server:", res.message);
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX error:", error);
        console.log("Response text:", xhr.responseText);
      },
    });
  }

  // =========================
  // FILTER SUB KATEGORI
  // =========================
  $("#id_kategori").on("change", function () {
    const kategoriId = $(this).val();

    // Jika user mengetik kategori baru (bukan angka ID)
    if (!kategoriId || isNaN(kategoriId)) {
      $("#id_sub_kategori").html(
        '<option value="">Pilih atau ketik sub kategori...</option>'
      );
      return;
    }

    // Filter sub kategori berdasarkan id_kategori
    const filtered = allSubKategori.filter(
      (sk) => sk.id_kategori == kategoriId
    );

    // Isi ulang dropdown sub kategori
    $("#id_sub_kategori")
      .empty()
      .append('<option value="">Pilih Sub Kategori</option>');
    filtered.forEach((sk) => {
      $("#id_sub_kategori").append(
        `<option value="${sk.id_sub_kategori}">${sk.nama_sub_kategori}</option>`
      );
    });

    // Re-init select2 agar tampilan update
    $("#id_sub_kategori").select2({
      dropdownParent: $("#produkModal"),
      tags: true,
      width: "100%",
      placeholder: "Pilih atau ketik...",
      createTag: function (params) {
        var term = $.trim(params.term);
        if (term === "") return null;
        return { id: term, text: term, newTag: true };
      },
    });
  });
  // FITUR PENCARIAN PRODUK
  // =========================
  $("#topbarInputIconLeft").on("keyup", function () {
    const keyword = $(this).val().trim();

    if (keyword.length === 0) {
      loadProduk(); // fungsi untuk reload semua produk
      return;
    }

    $.ajax({
      url: `${routeUrl}/search`, // pastikan routeUrl diarahkan ke controller produk
      type: "GET",
      data: { q: keyword },
      dataType: "json",
      success: function (res) {
        if (res.status === "success") {
          produkData = res.data || [];
          currentPage = 1;
          renderProdukPage(currentPage); // tampilkan hasil
          renderPagination(produkData.length, currentPage);
        } else {
          console.warn("Pencarian gagal:", res.message);
        }
      },
      error: function (xhr) {
        console.error("Error pencarian:", xhr.responseText);
      },
    });
  });

  // =========================
  // PREVIEW GAMBAR
  // =========================
  $("#gambar").on("change", function () {
    const container = $("#previewGambar");
    container.empty();
    const files = this.files;
    if (files) {
      Array.from(files).forEach((file) => {
        const reader = new FileReader();
        reader.onload = function (e) {
          const img = $("<img>")
            .attr("src", e.target.result)
            .addClass("img-thumbnail me-2 mb-2")
            .css({ width: "200px", height: "200px", objectFit: "cover" });
          container.append(img);
        };
        reader.readAsDataURL(file);
      });
    }
  });

  // =========================
  // LOAD PRODUK
  // =========================
  function loadProduk(page = 1) {
    $.getJSON("/produk/index", function (res) {
      produkData = res.data || [];
      renderProdukPage(page);
      renderPagination(produkData.length, page);
    });
  }

  // =========================
  // RENDER PRODUK
  // =========================
  function renderProdukPage(page) {
    const container = $("#produkContainer");
    container.empty();
    if (!produkData.length)
      return container.html('<p class="text-muted">Belum ada produk.</p>');

    const start = (page - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    const pageData = produkData.slice(start, end);

    pageData.forEach((item) => {
      const gambarUtama =
        item.gambar && item.gambar.length > 0
          ? item.gambar[0].path_gambar
          : "/img/no-image.png";
      container.append(`
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
          <div class="card h-100 border-0 shadow-sm rounded-0 overflow-hidden product-card position-relative">
            <img src="${gambarUtama}" class="card-img-top img-fluid rounded-0 detail-image" 
              alt="${item.nama_produk}" data-nama="${
        item.nama_produk
      }" data-deskripsi="${item.deskripsi || ""}" 
              data-gambar='${JSON.stringify(
                item.gambar || []
              )}' style="height:220px;object-fit:cover;cursor:pointer;">
            <div class="card-body d-flex flex-column px-3">
              <div class="fw-bold text-dark mb-1 text-truncate">${
                item.nama_produk
              }</div>
              <div class="small text-secondary flex-grow-1 text-truncate2 mb-3">${
                item.deskripsi || ""
              }</div>
              <div class="mb-3">
                <div class="fw-semibold text-primary" style="font-size:1.05rem;">${formatRupiah(
                  String(Math.floor(item.harga || 0))
                )}</div>
                <div class="small text-muted">Stok: ${item.stok}</div>
              </div>
              <div class="d-flex gap-2">
                <button class="btn btn-sm btn-outline-warning w-50 rounded-pill btnEdit" data-id="${
                  item.id_produk
                }"><i class="bi bi-pencil"></i> Edit</button>
                <button class="btn btn-sm btn-outline-danger w-50 rounded-pill btnDelete" data-id="${
                  item.id_produk
                }"><i class="bi bi-trash"></i> Hapus</button>
              </div>
            </div>
          </div>
        </div>
      `);
    });
  }

  // =========================
  // PAGINATION
  // =========================
  function renderPagination(totalItems, currentPage) {
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    const pagination = $("#pagination");
    pagination.empty();
    if (totalPages <= 1) return;
    const createPageItem = (label, page, disabled = false, active = false) => `
      <li class="page-item ${disabled ? "disabled" : ""} ${
      active ? "active" : ""
    }">
        <a class="page-link rounded-2" href="#" data-page="${page}">${label}</a>
      </li>`;
    pagination.append(createPageItem("&laquo;", 1, currentPage === 1));
    pagination.append(
      createPageItem("&lsaquo;", currentPage - 1, currentPage === 1)
    );
    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalPages, currentPage + 2);
    for (let i = startPage; i <= endPage; i++)
      pagination.append(createPageItem(i, i, false, i === currentPage));
    pagination.append(
      createPageItem("&rsaquo;", currentPage + 1, currentPage === totalPages)
    );
    pagination.append(
      createPageItem("&raquo;", totalPages, currentPage === totalPages)
    );

    pagination.find("a").on("click", function (e) {
      e.preventDefault();
      const targetPage = parseInt($(this).data("page"));
      if (targetPage && targetPage !== currentPage) {
        currentPage = targetPage;
        renderProdukPage(currentPage);
        renderPagination(totalItems, currentPage);
        window.scrollTo({ top: 0, behavior: "smooth" });
      }
    });
  }

  // =========================
  // TAMBAH PRODUK
  // =========================
  $("#btnAdd").click(function () {
    $("#produkForm")[0].reset();
    $("#previewGambar").empty();
    $("#nama_produk").val("");
    $(".select2").val(null).trigger("change");
    const modal = new bootstrap.Modal(document.getElementById("produkModal"));
    modal.show();
  });

  // =========================
  // SUBMIT FORM (ADD/UPDATE)
  // =========================
  $("#produkForm").on("submit", function (e) {
    e.preventDefault();
    const raw = $("#harga").val();
    $("#harga").val(parseRupiah(raw));

    const formData = new FormData(this);
    const action = $("#id_produk").val() ? "update_produk" : "add_produk";

    $.ajax({
      url: `${routeUrl}/${action}`,
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (res) {
        if (res.status === "success") {
          Swal.fire("Sukses", "Data berhasil disimpan", "success").then(() =>
            loadProduk(currentPage)
          );
          bootstrap.Modal.getInstance(
            document.getElementById("produkModal")
          ).hide();
        } else
          Swal.fire("Error", res.message || "Gagal menyimpan data", "error");
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

  // =========================
  // EDIT PRODUK
  // =========================
  $("#produkContainer").on("click", ".btnEdit", function () {
    const id = $(this).data("id");
    $("#produkForm")[0].reset();
    const modal = new bootstrap.Modal(document.getElementById("produkModal"));
    modal.show();
    $.ajax({
      url: `${routeUrl}/get_by_id`,
      type: "POST",
      data: { id_produk: id },
      dataType: "json",
      success: function (res) {
        if (res.status === "success") {
          const data = res.data;
          $("#id_produk").val(data.id_produk);
          $("#id_kategori").val(data.id_kategori).trigger("change");
          $("#id_sub_kategori").val(data.id_sub_kategori).trigger("change");
          $("#id_kain").val(data.id_kain).trigger("change");
          $("#nama_produk").val(data.nama_produk);
          $("#ukuran").val(data.ukuran);
          $("#harga").val("Rp " + Number(data.harga).toLocaleString("id-ID"));
          $("#stok").val(data.stok);
          $("#deskripsi").val(data.deskripsi);

          $("#previewGambar").empty();
          if (data.gambar && data.gambar.length) {
            data.gambar.forEach((g) => {
              $("#previewGambar").append(
                $("<img>")
                  .attr("src", g.path_gambar)
                  .addClass("img-thumbnail me-2 mb-2")
                  .css({ width: "200px", height: "200px", objectFit: "cover" })
              );
            });
          }
        } else Swal.fire("Error", res.message, "error");
      },
    });
  });

  // =========================
  // DELETE PRODUK
  // =========================
  $("#produkContainer").on("click", ".btnDelete", function () {
    const id = $(this).data("id");
    Swal.fire({
      title: "Hapus Produk?",
      text: "Produk akan dihapus permanen!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Hapus",
      cancelButtonText: "Batal",
    }).then((result) => {
      if (result.isConfirmed) {
        $.post(
          `${routeUrl}/delete_produk`,
          { id_produk: id },
          function (res) {
            if (res.status === "success")
              Swal.fire(
                "Terhapus!",
                "Produk berhasil dihapus.",
                "success"
              ).then(() => loadProduk(currentPage));
            else Swal.fire("Error", res.message, "error");
          },
          "json"
        );
      }
    });
  });

  // =========================
  // DETAIL PRODUK
  // =========================
  $("#produkContainer").on("click", ".detail-image", function () {
    const nama = $(this).data("nama");
    const deskripsi = $(this).data("deskripsi");
    const gambar = $(this).data("gambar") || [];
    $("#detailProdukTitle").text(nama);
    $("#detailProdukDeskripsi").text(deskripsi);
    const container = $("#detailProdukImages").empty();
    if (gambar.length) {
      gambar.forEach((g) => {
        container.append(
          $("<img>").attr("src", g.path_gambar).addClass("detail-image-modal")
        );
      });
    } else container.html('<img src="/img/no-image.png" class="detail-image-modal">');
    new bootstrap.Modal(document.getElementById("detailProdukModal")).show();
  });

  loadOptions();
  loadProduk();
});
