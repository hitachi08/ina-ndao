(function ($) {
  "use strict";

  // Spinner
  var spinner = function () {
    setTimeout(function () {
      if ($("#spinner").length > 0) {
        $("#spinner").removeClass("show");
      }
    }, 1);
  };
  spinner();

  // Initiate the wowjs
  new WOW().init();

  // Sticky Navbar
  $(window).scroll(function () {
    if ($(this).scrollTop() > 300) {
      $(".sticky-top").addClass("bg-white shadow-sm").css("top", "0px");
    } else {
      $(".sticky-top").removeClass("bg-white shadow-sm").css("top", "-150px");
    }
  });

  // Back to top button
  $(window).scroll(function () {
    if ($(this).scrollTop() > 100) {
      $(".back-to-top").fadeIn("slow");
    } else {
      $(".back-to-top").fadeOut("slow");
    }
  });
  $(".back-to-top").click(function () {
    $("html, body").animate({ scrollTop: 0 }, 1500, "easeInOutExpo");
    return false;
  });

  // Header carousel
  $(".header-carousel").owlCarousel({
    autoplay: true,
    smartSpeed: 1000,
    loop: true,
    dots: true,
    items: 1,
  });

  // Testimonials carousel
  $(".testimonial-carousel").owlCarousel({
    items: 1,
    autoplay: true,
    smartSpeed: 1000,
    animateIn: "fadeIn",
    animateOut: "fadeOut",
    dots: true,
    loop: true,
    nav: false,
  });
})(jQuery);



$(document).ready(function () {
  function initPagination(
    containerSelector,
    itemSelector,
    paginationSelector,
    itemsPerPage = 18
  ) {
    const items = $(`${containerSelector} ${itemSelector}`);
    const numItems = items.length;
    const numPages = Math.ceil(numItems / itemsPerPage);

    // Kosongkan pagination
    $(paginationSelector).empty();

    if (numPages <= 1) {
      items.show(); // Kalau cuma 1 halaman, tampilkan semua tanpa pagination
      return;
    }

    // Buat tombol pagination
    for (let i = 1; i <= numPages; i++) {
      $(paginationSelector).append(
        `<li class="page-item"><a class="page-link" href="#">${i}</a></li>`
      );
    }

    // Tampilkan halaman pertama
    items.hide().slice(0, itemsPerPage).show();
    $(`${paginationSelector} li:first`).addClass("active");

    // Event klik pagination
    $(`${paginationSelector} li`).on("click", function (e) {
      e.preventDefault();
      $(`${paginationSelector} li`).removeClass("active");
      $(this).addClass("active");

      const page = $(this).text();
      const start = (page - 1) * itemsPerPage;
      const end = start + itemsPerPage;

      items.hide().slice(start, end).show();
    });
  }

  initPagination("#galeri-list", ".col-lg-6", "#pagination-galeri", 6);
  initPagination("#product-list", ".col-6", "#pagination", 18);
});

