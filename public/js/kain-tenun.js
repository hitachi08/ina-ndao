$(document).ready(function () {
  let allData = []; 
  let filteredData = []; 
  let currentPage = 1;
  const itemsPerPage = 12;

  loadKain();
  loadFilters();

  // ==================== LOAD FILTER OPTIONS ====================
  function loadFilters() {
    $.ajax({
      url: "/galeri/get_options_kain",
      type: "GET",
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          const daerahContainer = $("#filterDaerahContainer");
          const jenisContainer = $("#filterJenisKainContainer");

          daerahContainer.empty();
          response.daerah.forEach((item) => {
            daerahContainer.append(`
                <div class="form-check">
                    <input class="form-check-input filter-daerah" type="checkbox" value="${item.id_daerah}" id="daerah${item.id_daerah}">
                    <label class="form-check-label" for="daerah${item.id_daerah}">${item.nama_daerah}</label>
                </div>
            `);
          });

          jenisContainer.empty();
          response.jenis.forEach((item) => {
            jenisContainer.append(`
                <div class="form-check">
                    <input class="form-check-input filter-jenis" type="checkbox" value="${item.id_jenis_kain}" id="jenis${item.id_jenis_kain}">
                    <label class="form-check-label" for="jenis${item.id_jenis_kain}">${item.nama_jenis}</label>
                </div>
            `);
          });
        }
      },
    });
  }

  // ==================== EVENT FILTER ====================
  $(document).on("change", ".filter-daerah, .filter-jenis", function () {
    applyFilter();
  });
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
    const jenis_kain = $(".filter-jenis:checked")
      .map(function () {
        return $(this).val();
      })
      .get();
    const harga_min = $("#hargaMin").val();
    const harga_max = $("#hargaMax").val();

    const container = $("#product-list");
    container.css("position", "relative");

    container.html(`
        <div class="loading-overlay d-flex flex-column align-items-center justify-content-center w-100" style="min-height:300px;">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;"></div>
            <p class="mt-3 text-muted">Menyaring data...</p>
        </div>
    `);

    $.ajax({
      url: "/galeri/filter",
      type: "POST",
      dataType: "json",
      data: {
        daerah,
        jenis_kain,
        harga_min,
        harga_max,
      },
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
        $("#pagination").empty();
      },
    });
  }

  // ==================== EVENT SEARCH ====================
  $("#searchKain").on("input", function () {
    const keyword = $(this).val().trim();
    if (keyword === "") {
      filteredData = allData;
      currentPage = 1;
      renderProdukWithPagination(filteredData);
    } else {
      applySearch(keyword);
    }
  });

  // ==================== FUNGSI SEARCH AJAX ====================
  function applySearch(keyword) {
    const container = $("#product-list");
    container.html(`
        <div class="loading-overlay d-flex flex-column align-items-center justify-content-center w-100" style="min-height:300px;">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;"></div>
            <p class="mt-3 text-muted">Mencari kain "${keyword}"...</p>
        </div>
    `);

    $.ajax({
      url: "/galeri/search",
      type: "GET",
      dataType: "json",
      data: {
        q: keyword,
      },
      success: function (response) {
        if (response.status === "success" && response.data.length > 0) {
          filteredData = response.data;
          currentPage = 1;
          renderProdukWithPagination(filteredData);
        } else {
          container.html(`
                <div class="col-12 text-center py-5 w-100">
                    <p class="text-muted">Tidak ditemukan kain yang cocok dengan "<strong>${keyword}</strong>".</p>
                </div>
            `);
          $("#pagination").empty();
        }
      },
      error: function () {
        container.html(`
            <div class="col-12 text-center py-5 w-100">
                <p class="text-danger">Terjadi kesalahan saat mencari kain.</p>
            </div>
        `);
      },
    });
  }

  // ==================== LOAD SEMUA DATA ====================
  function loadKain() {
    $.ajax({
      url: "/galeri/fetch_all",
      type: "GET",
      dataType: "json",
      success: function (response) {
        if (response.status === "success" && response.data.length > 0) {
          allData = response.data;
          filteredData = allData;
          renderProdukWithPagination(allData);
        } else {
          $("#product-list").html(
            `<div class="col-12 text-center py-4 w-100"><p class="text-muted">Belum ada data kain yang tersedia.</p></div>`
          );
        }
      },
      error: function () {
        $("#product-list").html(
          `<div class="col-12 text-center py-4 w-100"><p class="text-danger">Terjadi kesalahan saat memuat data galeri.</p></div>`
        );
      },
    });
  }

  // ==================== RENDER DENGAN PAGINATION ====================
  function renderProdukWithPagination(data) {
    const totalPages = Math.ceil(data.length / itemsPerPage);
    const start = (currentPage - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    const pageData = data.slice(start, end);

    renderProduk(pageData);
    renderPagination(totalPages);
  }

  // ==================== RENDER PRODUK ====================
  function renderProduk(data) {
    const container = $("#product-list");
    container.empty();

    if (!data || data.length === 0) {
      container.html(
        `<div class="col-12 text-center py-4 w-100"><p class="text-muted">Tidak ada data yang sesuai filter.</p></div>`
      );
      return;
    }

    data.forEach((item) => {
      const imgSrc = item.motif_gambar?.length
        ? item.motif_gambar[0].path_gambar
        : "/assets/img/no-image.png";
      const namaProduk =
        `${item.nama_jenis || ""} ${item.nama_daerah || ""}`.trim() || "-";
      const motif = item.nama_motif || "-";
      const harga = formatRupiah(item.harga);

      const card = `
            <div class="col-6 col-md-4 col-lg-3 mb-4">
                <a href="/kain/detail/${item.slug}" class="text-decoration-none">
                    <div class="box-card shadow h-100 cursor-pointer">
                        <figure>
                            <img src="${imgSrc}" alt="${motif}">
                        </figure>
                        <div class="desc-card">
                            <h5><div class="fw-bold text-dark mb-1">${namaProduk}</div></h5>
                            <div class="abs-btm">
                                <div class="text-muted small mb-2 motif">Motif ${motif}</div>
                                <div class="fw-bold text-primary price" style="font-size: 1rem;">${harga},-</div>
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

  function renderPagination(totalPages) {
    renderPaginationGlobal(
      "#pagination",
      currentPage,
      totalPages,
      function (page) {
        currentPage = page;
        renderProdukWithPagination(filteredData);
      }
    );
  }

  // ==================== FORMAT RUPIAH ====================
  function formatRupiah(angka) {
    if (!angka) return "Rp 0";
    return "Rp " + parseFloat(angka).toLocaleString("id-ID");
  }
});
