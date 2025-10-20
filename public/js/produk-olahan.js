$(document).ready(function () {
  let allData = [];
  let filteredData = [];
  let currentPage = 1;
  const itemsPerPage = 12;

  // Jalankan saat halaman pertama kali dimuat
  loadProdukOlahan();
  loadFilters();

  // ==================== LOAD FILTER ====================
  function loadFilters() {
    $.ajax({
      url: "/produk/get_options",
      type: "GET",
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          const data = response.data; // Ambil data
          const daerahContainer = $("#filterDaerahContainer");
          const jenisContainer = $("#filterJenisKainContainer");
          const kategoriContainer = $("#filterKategoriContainer");
          const subKategoriContainer = $("#filterSubKategoriContainer");

          daerahContainer.empty();
          jenisContainer.empty();
          kategoriContainer.empty();
          subKategoriContainer.empty();

          // Daerah
          (data.daerah || []).forEach((item) => {
            daerahContainer.append(`
            <div class="form-check">
              <input class="form-check-input filter-daerah" type="checkbox" value="${item.id_daerah}" id="daerah${item.id_daerah}">
              <label class="form-check-label" for="daerah${item.id_daerah}">${item.nama_daerah}</label>
            </div>
          `);
          });

          // Jenis Kain
          (data.jenis_kain || []).forEach((item) => {
            jenisContainer.append(`
            <div class="form-check">
              <input class="form-check-input filter-jenis" type="checkbox" value="${item.id_jenis_kain}" id="jenis_kain${item.id_jenis_kain}">
              <label class="form-check-label" for="jenis_kain${item.id_jenis_kain}">${item.nama_jenis}</label>
            </div>
          `);
          });

          // Kategori
          (data.kategori || []).forEach((item) => {
            kategoriContainer.append(`
            <div class="form-check">
              <input class="form-check-input filter-kategori" type="checkbox" value="${item.id_kategori}" id="kategori${item.id_kategori}">
              <label class="form-check-label" for="kategori${item.id_kategori}">${item.nama_kategori}</label>
            </div>
          `);
          });

          // Sub-Kategori
          (data.sub_kategori || []).forEach((item) => {
            subKategoriContainer.append(`
            <div class="form-check">
              <input class="form-check-input filter-subkategori" type="checkbox" value="${item.id_sub_kategori}" id="sub_kategori${item.id_sub_kategori}">
              <label class="form-check-label" for="sub_kategori${item.id_sub_kategori}">${item.nama_sub_kategori}</label>
            </div>
          `);
          });
        }
      },
    });
  }


  // ==================== EVENT FILTER ====================
  $(document).on(
    "change",
    ".filter-daerah, .filter-jenis, .filter-kategori, .filter-subkategori",
    function () {
      applyFilter();
    }
  );
  $("#hargaMin, #hargaMax").on("input", function () {
    applyFilter();
  });

  // ==================== APPLY FILTER ====================
  function applyFilter() {
    const daerah = $(".filter-daerah:checked")
      .map(function () {
        return $(this).val();
      })
      .get();
    const jenis = $(".filter-jenis:checked")
      .map(function () {
        return $(this).val();
      })
      .get();
    const kategori = $(".filter-kategori:checked")
      .map(function () {
        return $(this).val();
      })
      .get();
    const subkategori = $(".filter-subkategori:checked")
      .map(function () {
        return $(this).val();
      })
      .get();
    const harga_min = $("#hargaMin").val();
    const harga_max = $("#hargaMax").val();

    const container = $("#product-olahan-list");
    container.html(`
            <div class="text-center py-5 w-100">
                <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;"></div>
                <p class="mt-3 text-muted">Menyaring data produk...</p>
            </div>
        `);

    $.ajax({
      url: "/produk/filter",
      type: "POST",
      dataType: "json",
      data: { daerah, jenis, kategori, subkategori, harga_min, harga_max },
      success: function (response) {
        if (response.status === "success") {
          filteredData = response.data;
          currentPage = 1;
          renderProdukWithPagination(filteredData);
        } else {
          container.html(
            `<div class="col-12 text-center py-4 w-100"><p class="text-muted">Tidak ditemukan hasil sesuai filter.</p></div>`
          );
          $("#pagination").empty();
        }
      },
      error: function () {
        container.html(
          `<div class="col-12 text-center py-4 w-100"><p class="text-danger">Terjadi kesalahan saat memuat data filter.</p></div>`
        );
      },
    });
  }

  // ==================== LOAD SEMUA PRODUK ====================
  function loadProdukOlahan() {
    $.ajax({
      url: "/produk/index",
      type: "GET",
      dataType: "json",
      success: function (response) {
        if (response.status === "success" && response.data.length > 0) {
          allData = response.data;
          filteredData = allData;
          renderProdukWithPagination(allData);
        } else {
          $("#product-olahan-list").html(
            `<div class="col-12 text-center py-4 w-100"><p class="text-muted">Belum ada produk olahan yang tersedia.</p></div>`
          );
        }
      },
      error: function () {
        $("#product-olahan-list").html(
          `<div class="col-12 text-center py-4 w-100"><p class="text-danger">Gagal memuat data produk olahan.</p></div>`
        );
      },
    });
  }

  // ==================== RENDER PRODUK ====================
  function renderProdukWithPagination(data) {
    const totalPages = Math.ceil(data.length / itemsPerPage);
    const start = (currentPage - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    const pageData = data.slice(start, end);

    renderProduk(pageData);
    renderPagination(totalPages);
  }

  function renderProduk(data) {
    const container = $("#product-olahan-list");
    container.empty();

    if (!data || data.length === 0) {
      container.html(
        `<div class="col-12 text-center py-4 w-100"><p class="text-muted">Tidak ada produk sesuai filter.</p></div>`
      );
      return;
    }

    data.forEach((item) => {
      const imgSrc = item.gambar?.length
        ? item.gambar[0].path_gambar
        : "/assets/img/no-image.png";
      const namaProduk = item.nama_produk || "-";
      const harga = formatRupiah(item.harga);
      const kategori = item.nama_kategori || "-";

      const card = `
                <div class="col-6 col-md-4 col-lg-3 mb-4">
                    <a href="/produk/detail/${item.slug}?lang=${currentLang}" class="text-decoration-none">
                        <div class="box-card shadow h-100 cursor-pointer">
                            <figure>
                                <img src="${imgSrc}" alt="${namaProduk}">
                            </figure>
                            <div class="desc-card">
                                <h5><div class="fw-bold text-dark mb-1">${namaProduk}</div></h5>
                                <div class="abs-btm">
                                  <div class="text-muted small mb-2">Kategori ${kategori}</div>
                                  <div class="fw-bold text-primary">${harga}</div>
                                  <div class="small fw-semibold text-secondary mt-2" style="letter-spacing: .5px; font-size: .8rem;">
                                      <span class="d-inline d-md-none">Tenun NTT</span>
                                      <span class="d-none d-md-inline">Tenun Tradisional NTT</span>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            `;
      container.append(card);
    });
  }

  // ==================== RENDER PAGINATION ====================
  function renderPagination(totalPages) {
    const pagination = $("#pagination");
    pagination.empty();
    if (totalPages <= 1) return;

    const disabledPrev = currentPage === 1 ? "disabled" : "";
    const disabledNext = currentPage === totalPages ? "disabled" : "";

    pagination.append(`
            <li class="page-item ${disabledPrev}">
                <a class="page-link" href="#" data-page="${
                  currentPage - 1
                }"><i class="bi bi-chevron-left"></i></a>
            </li>
        `);

    for (let i = 1; i <= totalPages; i++) {
      const active = i === currentPage ? "active bg-dark border-dark" : "";
      pagination.append(`
                <li class="page-item ${active}">
                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                </li>
            `);
    }

    pagination.append(`
            <li class="page-item ${disabledNext}">
                <a class="page-link" href="#" data-page="${
                  currentPage + 1
                }"><i class="bi bi-chevron-right"></i></a>
            </li>
        `);

    $(".page-link")
      .off("click")
      .on("click", function (e) {
        e.preventDefault();
        const page = parseInt($(this).data("page"));
        if (page >= 1 && page <= totalPages) {
          currentPage = page;
          renderProdukWithPagination(filteredData);
        }
      });
  }

  // ==================== FORMAT RUPIAH ====================
  function formatRupiah(angka) {
    if (!angka) return "Rp 0";
    return "Rp " + parseFloat(angka).toLocaleString("id-ID");
  }
});
