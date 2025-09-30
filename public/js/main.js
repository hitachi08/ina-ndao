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

  $(".event-carousel").owlCarousel({
    items: 3,
    margin: 20,
    autoplay: true,
    smartSpeed: 1000,
    dots: true,
    loop: true,
    nav: false,
    responsive: {
      0: { items: 1 },
      768: { items: 2 },
      992: { items: 3 },
    },
  });
})(jQuery);

$(document).ready(function () {
  var itemsPerPage = 18;
  var items = $("#product-list .col-6");
  var numItems = items.length;
  var numPages = Math.ceil(numItems / itemsPerPage);

  for (var i = 1; i <= numPages; i++) {
    $("#pagination").append(
      `<li class="page-item"><a class="page-link" href="#">${i}</a></li>`
    );
  }

  items.hide();
  items.slice(0, itemsPerPage).show();
  $("#pagination li:first").addClass("active");

  $("#pagination li").click(function (e) {
    e.preventDefault();
    $("#pagination li").removeClass("active");
    $(this).addClass("active");

    var page = $(this).text();
    var start = (page - 1) * itemsPerPage;
    var end = start + itemsPerPage;

    items.hide().slice(start, end).show();
  });
});
