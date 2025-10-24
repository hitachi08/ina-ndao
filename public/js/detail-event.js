$(document).ready(function () {
  if (typeof slug === "undefined" || !slug) {
    $("#event-detail").html(
      `<div class="alert alert-warning">Slug tidak ditemukan.</div>`
    );
    return;
  }

  $.ajax({
    url: "/event/detail",
    type: "POST",
    data: {
      idOrSlug: slug,
    },
    dataType: "json",
    success: function (res) {
      if (res.status === "success") {
        let ev = res.event;

        const eventDate = new Date(ev.tanggal);
        const formattedDate = new Intl.DateTimeFormat("id-ID", {
          weekday: "long",
          day: "2-digit",
          month: "long",
          year: "numeric",
        }).format(eventDate);

        let formattedTime = "";
        if (ev.waktu) {
          const [hour, minute] = ev.waktu.split(":");
          formattedTime = `${hour.padStart(2, "0")}.${minute.padStart(2, "0")}`;
        }

        const today = new Date();
        const isUpcoming = eventDate >= today;
        const badgeHTML = isUpcoming
          ? `<span class="badge bg-primary position-absolute top-0 start-0 m-3 px-3 py-2">Segera Hadir</span>`
          : "";

        let html = `
            <div class="card shadow-sm wow fadeIn position-relative overflow-hidden">
                ${badgeHTML}
                <div class="row g-4 align-items-start flex-column flex-md-row">
                    <!-- Gambar Event -->
                    <div class="col-12 col-md-5">
                        <img src="/uploads/event/${ev.gambar_banner}" 
                             class="event-banner shadow-sm rounded w-100" 
                             alt="${ev.nama_event}">
                    </div
                    <!-- Konten Detail -->
                    <div class="col-12 col-md-7 p-3">
                        <h2 class="card-title mb-3 fw-bold" style="font-size: 1.8rem;">${
                          ev.nama_event
                        }</h2
                        <p class="mb-2">
                            <i class="bi bi-geo-alt-fill me-2"></i>
                            <strong>${ev.tempat}</strong>
                        </p
                        <p class="mb-1 text-primary">
                            <strong>${formattedDate}</strong>
                        </p
                        <p class="mb-3 text-muted">
                            ${
                              formattedTime
                                ? formattedTime + " WITA"
                                : "-"
                            }
                        </p
                        <p class="mt-3">${ev.deskripsi}</p>
                    </div>
                </div>
            </div>
        `;
        $("#event-detail").html(html);

        $("#event-docs").empty();

        if (res.dokumentasi && res.dokumentasi.length > 0) {
          res.dokumentasi.forEach((doc) => {
            $("#event-docs").append(`
                <div class="col-md-3 mb-3">
                    <img src="/uploads/event/${doc.gambar_dokumentasi}" class="event-doc shadow" alt="Dokumentasi">
                </div>
            `);
          });
        } else {
          $("#event-docs").html(`
                <div class="col-12 text-center text-muted py-4">
                    <i class="bi bi-image" style="font-size: 2rem;"></i>
                    <p class="mt-2 mb-0">Belum ada dokumentasi untuk event ini.</p>
                </div>
            `);
        }
      } else {
        $("#event-detail").html(
          `<div class="alert alert-danger">${res.message}</div>`
        );
      }
    },
    error: function () {
      $("#event-detail").html(
        `<div class="alert alert-danger">Terjadi kesalahan saat memuat data event.</div>`
      );
    },
  });
});
