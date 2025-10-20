$(document).ready(function () {
  const routeUrl = "/galeri";

  loadGaleri();

  // Ketika daerah di peta diklik
 $("#peta-ntt path").on("click", function () {
   const daerahData = $(this).attr("data-daerah");

   if (daerahData) {
     // Pisahkan nama-nama daerah jadi array
     const daerahArray = daerahData.split(",").map((d) => d.trim());

     // Kirim ke server untuk filter
     loadGaleriByDaerah(daerahArray);
   }
 });

  // Fungsi ambil galeri berdasarkan daerah
  function loadGaleriByDaerah(daerahArray) {
    $.ajax({
      url: `${routeUrl}/fetch_by_daerah`,
      type: "POST",
      data: JSON.stringify({ daerah: daerahArray }),
      contentType: "application/json",
      dataType: "json",
      success: function (res) {
        if (res.status === "success") {
          renderGaleri(res.data);
        } else {
          $("#galeri-list").html(
            "<p class='text-center'>Tidak ada kain dari daerah tersebut.</p>"
          );
        }
      },
      error: function () {
        $("#galeri-list").html(
          "<p class='text-center'>Terjadi kesalahan koneksi.</p>"
        );
      },
    });
  }

  // Fungsi untuk ambil semua data kain
  function loadGaleri() {
    $.ajax({
      url: `${routeUrl}/fetch_all`,
      type: "GET",
      dataType: "json",
      success: function (res) {
        if (res.status === "success") {
          renderGaleri(res.data);
        } else {
          $("#galeri-list").html(
            '<p class="text-center">Gagal memuat data kain.</p>'
          );
        }
      },
      error: function () {
        $("#galeri-list").html(
          '<p class="text-center">Terjadi kesalahan koneksi.</p>'
        );
      },
    });
  }

  // Fungsi untuk menampilkan data kain ke HTML
  function renderGaleri(data) {
    let html = "";

    data.forEach((item) => {
      // Ambil gambar pertama dari tabel kain_gambar
      const gambar =
        item.motif_gambar && item.motif_gambar.length > 0
          ? item.motif_gambar[0].path_gambar
          : "img/default.png";

      // Potong makna menjadi 25 kata dulu
      const maknaPendek = item.makna
        ? item.makna.split(" ").slice(0, 25).join(" ") + "..."
        : "Belum ada makna motif.";

      html += `
            <div class="col-lg-6 col-md-6 wow fadeIn team-item" data-wow-delay="0.1s">
                <div class="card shadow h-100 border-0 rounded-3 overflow-hidden">
                    <div class="row g-0 align-items-center">
                        <div class="col-5">
                            <div class="position-relative overflow-hidden shadow">
                                <img class="img-fluid w-100" src="${gambar}" alt="${
        item.nama_motif
      }">
                                <div class="team-overlay">
                                    <small class="position-absolute top-0 start-0 m-2">${
                                      item.nama_jenis
                                    }</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-7 p-3">
                            <h5 class="mb-2">${item.nama_motif}</h5>
                            <p class="small mb-3 text-justify short-text">${maknaPendek}</p>
                            <p class="small mb-3 text-justify full-text d-none">${
                              item.makna || ""
                            }</p>
                            <a href="#!" class="btn btn-sm btn-primary toggle-text">Lebih Lanjut</a>
                        </div>
                    </div>
                </div>
            </div>`;
    });

    $("#galeri-list").html(html);
  }

  // Tombol "Lebih Lanjut" untuk toggle teks
  $(document).on("click", ".toggle-text", function (e) {
    e.preventDefault();
    const card = $(this).closest(".card");
    const shortText = card.find(".short-text");
    const fullText = card.find(".full-text");

    if (fullText.hasClass("d-none")) {
      shortText.addClass("d-none");
      fullText.removeClass("d-none");
      $(this).text("Tampilkan Lebih Sedikit");
    } else {
      shortText.removeClass("d-none");
      fullText.addClass("d-none");
      $(this).text("Lebih Lanjut");
    }
  });
});
