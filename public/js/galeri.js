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
      "TTS",
      "Soe",
      "Amanatun",
      "Amanuban",
      "Nunkolo",
      "Kie",
      "Boking",
      "Noebana",
    ],
    ttu: ["TTU", "Kefamenanu", "Biboki", "Insana", "Noemuti"],
  };

  loadAllKain();

  let selectedDaerah = null;

  const defaultColor = "#9a6423";
  const hoverColor = "#6d4819";
  const selectedColor = "#264653";

  const $paths = $("#peta-ntt svg path");

  // set default color pakai attr
  $paths.attr("fill", defaultColor).css("cursor", "pointer");

  $paths.hover(
    function () {
      if ($(this).attr("data-active") !== "true") {
        $(this).attr("fill", hoverColor);
      }
    },
    function () {
      if ($(this).attr("data-active") !== "true") {
        $(this).attr("fill", defaultColor);
      }
    }
  );

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
        if (response.status !== "success") {
          $("#galeri-list").html(`
            <div class="text-center text-danger py-5">
              Gagal memuat data kain.
            </div>
          `);
          return;
        }

        renderKainList(response.data, "Semua Daerah");
      })
      .catch((err) => {
        $("#galeri-list").html(`
          <div class="text-center text-danger py-5">
            Terjadi kesalahan: ${err.message}
          </div>
        `);
      });
  }

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
        if (response.status !== "success") {
          $("#galeri-list").html(`
            <div class="text-center text-danger py-5">
              Gagal memuat data kain dari daerah ini.
            </div>
          `);
          return;
        }

        renderKainList(response.data, daerah);
      })
      .catch((err) => {
        $("#galeri-list").html(`
          <div class="text-center text-danger py-5">
            Terjadi kesalahan: ${err.message}
          </div>
        `);
      });
  }

  function renderKainList(kainList, daerah) {
    let html = `
      <h4 class="text-center mb-4">
        Kain Tenun dari <span class="text-primary">${daerah}</span>
      </h4>
      <div class="row g-4">
    `;

    if (kainList.length > 0) {
      kainList.forEach((kain) => {
        const imgSrc =
          kain.motif_gambar && kain.motif_gambar.length > 0
            ? kain.motif_gambar[0].path_gambar.replace(/\\/g, "")
            : "/img/no-image.png";

        html += `
          <div class="col-6 col-sm-4 col-md-3">
            <div class="card h-100 shadow-sm border-0">
              <img src="${imgSrc}" class="card-img-top" alt="${
                    kain.nama_motif
                  }" style="height: 250px; object-fit: cover;">
              <div class="card-body p-2">
                <h6 class="card-title mb-1 text-primary" style="font-size: 0.8rem;">
                  ${kain.nama_jenis} ${kain.nama_daerah}
                </h6>
                <p class="card-text small mb-1">Motif ${
                  kain.nama_motif
                }</p>
                <p class="card-text small text-muted">${kain.makna ?? ""}</p>
              </div>
            </div>
          </div>
        `;
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
  }
});
