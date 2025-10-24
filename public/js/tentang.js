$(document).ready(function () {
  $.ajax({
    url: "/event/index",
    method: "GET",
    dataType: "json",
    success: function (res) {
      if (res.status === "success") {
        function slugify(text) {
          return text
            .toString()
            .toLowerCase()
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "")
            .replace(/[^a-z0-9]+/g, "-")
            .replace(/^-+|-+$/g, "");
        }

        const upcomingEvents = res.upcoming || [];
        let upcomingHTML = "";

        upcomingEvents.forEach((ev) => {
          const tanggal = new Date(ev.tanggal).toLocaleDateString("id-ID", {
            day: "2-digit",
            month: "long",
            year: "numeric",
          });

          const slug = slugify(ev.nama_event);

          upcomingHTML += `
            <div class="item">
                <a href="/event/detail/${slug}?lang=<?= $currentLang ?>" class="text-decoration-none text-dark">
                    <div class="card product-card cursor-pointer shadow border-0 h-100 mb-4">
                        <div class="position-relative">
                            <img class="card-img-top rounded" src="/uploads/event/${encodeURIComponent(
                              ev.gambar_banner ?? "no-image.png"
                            )}" alt="${ev.nama_event}">
                            <span class="badge bg-primary position-absolute top-0 start-0 m-3 px-3 py-2">Segera Hadir</span>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">${ev.nama_event}</h5>
                            <p class="card-text">${ev.deskripsi}</p>
                            <ul class="list-unstyled small mb-0 mt-auto">
                                <li><i class="fa fa-calendar text-primary me-2"></i> ${tanggal}</li>
                                <li><i class="fa fa-map-marker-alt text-primary me-2"></i> ${
                                  ev.tempat
                                }</li>
                                <li><i class="fa fa-clock text-primary me-2"></i> ${
                                  ev.waktu
                                }</li>
                            </ul>
                        </div>
                    </div>
                </a>
            </div>`;
        });

        $("#upcomingEvents").html(upcomingHTML);

        var $carousel = $("#upcomingEvents");
        var itemCount = $carousel.find(".item").length;

        if (itemCount > 0) {
          $carousel.owlCarousel({
            items: 3,
            margin: 20,
            autoplay: false,
            smartSpeed: 1000,
            dots: true,
            loop: itemCount > 3,
            nav: false,
            responsive: {
              0: {
                items: 1,
              },
              768: {
                items: 2,
              },
              992: {
                items: 3,
              },
            },
          });
        }

        const pastEvents = res.past || [];
        let pastHTML = "";

        pastEvents.forEach((ev) => {
          let docImg = ev.gambar_banner || "no-image.png";
          let slug = slugify(ev.nama_event);

          pastHTML += `
            <div class="project-item position-relative overflow-hidden">
                <img class="img-fluid w-100" src="/uploads/event/${encodeURIComponent(
                  docImg
                )}" alt="${ev.nama_event}">
                <a class="project-overlay justify-content-between text-decoration-none" href="/event/detail/${slug}?lang=<?= $currentLang ?>">
                    <h4 class="text-white description-text fs-5">${
                      ev.nama_event
                    }</h4>
                    <small class="text-white description-text">${
                      ev.deskripsi
                    }</small>
                </a>
            </div>`;
        });

        $("#pastEvents").html(pastHTML);
      } else {
        Swal.fire("Oops...", res.message, "error");
      }
    },
    error: function () {
      Swal.fire(
        "Oops...",
        "Terjadi kesalahan saat mengambil data event",
        "error"
      );
    },
  });
});
