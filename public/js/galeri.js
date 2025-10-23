$(document).ready(function () {
  const daerahMap = {
    alor: ["Alor", "Kalabahi", "Teluk Mutiara", "Kabola", "Pureman"],
    belu: ["Belu", "Atambua", "Lamaknen", "Raihat", "Kakuluk Mesak"],
    ende: ["Ende", "Ndona", "Wolowaru", "Detusoko", "Maurole"],
    "flores timur": ["Flores Timur", "Larantuka", "Titehena", "Ile Mandiri"],
    "kota kupang": ["Kota Kupang", "Oebobo", "Kelapa Lima", "Alak", "Maulafa"],
    kupang: ["Kupang", "Oelamasi", "Takari", "Amarasi", "Fatuleu"],
    lembata: ["Lembata", "Lewoleba", "Ile Ape", "Nubatukan"],
    manggarai: ["Manggarai", "Ruteng", "Reok", "Cibal"],
    "manggarai barat": ["Manggarai Barat", "Labuan Bajo", "Komodo", "Boleng"],
    "manggarai timur": ["Manggarai Timur", "Borong", "Elar", "Kota Komba"],
    nagekeo: ["Nagekeo", "Mbay", "Boawae", "Aesesa"],
    ngada: ["Ngada", "Bajawa", "Aimere", "Golewa"],
    rote: ["Rote", "Ba’a", "Rote Barat", "Rote Timur", "Lobalain"],
    sabu: ["Sabu", "Raijua", "Seb’a", "Hawu Mehara"],
    sikka: ["Sikka", "Maumere", "Nita", "Koting"],
    sumba: [
      "Sumba",
      "Sumba Barat",
      "Sumba Barat Daya",
      "Sumba Tengah",
      "Sumba Timur",
      "Waingapu",
      "Tambolaka",
      "Waitabula",
      "Waibakul",
    ],
    tts: [
      "Timor Tengah Selatan",
      "TTS",
      "Soe",
      "Amanatun",
      "Amanuban",
      "Nunkolo",
      "Kie",
      "Boking",
      "Noebana",
    ],
    ttu: [
      "Timor Tengah Utara",
      "TTU",
      "Kefamenanu",
      "Biboki",
      "Insana",
      "Noemuti",
    ],
  };

  const defaultColor = "#9a6423";
  const hoverColor = "#6d4819";
  const selectedColor = "#264653";

  let selectedDaerah = null;
  let allKainData = [];
  let currentPage = 1;
  const itemsPerPage = 12;

  const $paths = $("#peta-ntt svg path");

  // ======== Warna awal dan hover ========
  $paths.attr("fill", defaultColor).css("cursor", "pointer");
  $paths.hover(
    function () {
      if ($(this).attr("data-active") !== "true")
        $(this).attr("fill", hoverColor);
    },
    function () {
      if ($(this).attr("data-active") !== "true")
        $(this).attr("fill", defaultColor);
    }
  );

  // ======== Klik daerah ========
  $paths.on("click", function () {
    const daerah =
      $(this).attr("data-name") || $(this).attr("id") || "Tanpa ID";

    if ($(this).attr("data-active") === "true") {
      $paths.attr("data-active", "false").attr("fill", defaultColor);
      selectedDaerah = null;
      loadAllKain();
      return;
    }

    $paths.attr("data-active", "false").attr("fill", defaultColor);
    $(this).attr("data-active", "true").attr("fill", selectedColor);
    selectedDaerah = daerah;
    loadKainByDaerah(daerah);
  });

  // ======== Load semua kain ========
  loadAllKain();

  function loadAllKain() {
    $("#galeri-list").html(`
      <div class="text-center py-5">
        <div class="spinner-border text-primary" role="status"></div>
        <p class="mt-2 mb-0">Memuat semua kain...</p>
      </div>
    `);

    fetch("/galeri/fetch_all")
      .then((res) => res.json())
      .then((response) => {
        if (response.status === "success") {
          allKainData = response.data;
          currentPage = 1;
          renderGaleriPage(currentPage);
          renderPagination(allKainData.length, currentPage);
        } else showError("Gagal memuat data kain.");
      })
      .catch((err) => showError(err.message));
  }

  // ======== Load kain per daerah ========
  function loadKainByDaerah(daerah) {
    const key = daerah.toLowerCase();
    const subDaerahList = daerahMap[key] || [daerah];

    $("#galeri-list").html(`
      <div class="text-center py-5">
        <div class="spinner-border text-primary" role="status"></div>
        <p class="mt-2 mb-0">Memuat kain dari <strong>${daerah}</strong>...</p>
      </div>
    `);

    fetch("/galeri/fetch_by_daerah", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ daerah_list: subDaerahList }),
    })
      .then((res) => res.json())
      .then((response) => {
        if (response.status === "success") {
          allKainData = response.data;
          currentPage = 1;
          renderGaleriPage(currentPage, daerah);
          renderPagination(allKainData.length, currentPage);
        } else showError("Gagal memuat data kain dari daerah ini.");
      })
      .catch((err) => showError(err.message));
  }

  function showError(message) {
    $("#galeri-list").html(`
      <div class="text-center text-danger py-5">
        Terjadi kesalahan: ${message}
      </div>
    `);
  }

  // ======== Render per halaman ========
  function renderGaleriPage(page = 1, daerah = "Semua Daerah") {
    const start = (page - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    const pagedData = allKainData.slice(start, end);
    renderKainList(pagedData, daerah);
  }

  // ======== Render daftar kain ========
  function renderKainList(kainList, daerah) {
    let html = `
      <h4 class="text-center mb-4">Kain Tenun dari <span class="text-primary">${daerah}</span></h4>
      <div class="row g-4 justify-content-center">
    `;

    if (kainList.length > 0) {
      kainList.forEach((kain, index) => {
        const gambarUtama =
          kain.motif_gambar && kain.motif_gambar.length > 0
            ? kain.motif_gambar[0].path_gambar.replace(/\\/g, "")
            : "/img/no-image.png";

        html += `
          <div class="col-6 col-sm-4 col-md-3">
            <a href="${gambarUtama}" 
               class="glightbox" 
               data-gallery="motif-${index}" 
               data-title="${kain.nama_jenis} ${kain.nama_daerah} Motif ${kain.nama_motif}">
              <div class="card border-0 shadow-sm hover-zoom">
                <img src="${gambarUtama}" class="card-img-top rounded" alt="${kain.nama_motif}" style="height: 250px; object-fit: cover;">
              </div>
            </a>
        `;

        // Gambar tambahan
        if (kain.motif_gambar && kain.motif_gambar.length > 1) {
          kain.motif_gambar.slice(1).forEach((g) => {
            const gPath = g.path_gambar.replace(/\\/g, "");
            html += `
              <a href="${gPath}" 
                 class="glightbox d-none" 
                 data-gallery="motif-${index}" 
                 data-title="${kain.nama_jenis} ${kain.nama_daerah} Motif ${kain.nama_motif}">
              </a>
            `;
          });
        }

        html += `</div>`;
      });
    } else {
      html += `
        <div class="col-12 text-center">
          <p class="text-muted">Belum ada kain dari daerah ini.</p>
        </div>
      `;
    }

    html += "</div>";
    $("#galeri-list").html(html);

    // Re-init GLightbox
    if (window.glightboxInstance) window.glightboxInstance.destroy();
    window.glightboxInstance = GLightbox({
      touchNavigation: true,
      loop: true,
      zoomable: true,
      autoplayVideos: false,
      closeButton: true,
    });
  }

  // ======== RENDER PAGINATION ========
  function renderPagination(totalItems, currentPage) {
    const totalPages = Math.ceil(totalItems / itemsPerPage);

    renderPaginationGlobal(
      "#pagination-galeri",
      currentPage,
      totalPages,
      (page) => {
        currentPage = page;
        renderGaleriPage(currentPage, selectedDaerah || "Semua Daerah");
        renderPagination(totalItems, currentPage);
      }
    );
  }
});
