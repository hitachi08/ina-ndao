const lightbox = GLightbox({
  selector: ".glightbox",
});

const notyf = new Notyf({
  duration: 2500,
  position: {
    x: "right",
    y: "top",
  },
  ripple: true,
});

const mainCarousel = $(".gallery-main").owlCarousel({
  items: 1,
  loop: true,
  nav: false,
  dots: false,
  margin: 10,
  autoplay: false,
  smartSpeed: 500,
});

const thumbCarousel = $(".gallery-thumbs").owlCarousel({
  items: 4,
  margin: 10,
  dots: false,
  nav: true,
  center: false,
  loop: false,
  navText: [
    '<i class="bi bi-chevron-left"></i>',
    '<i class="bi bi-chevron-right"></i>',
  ],
  responsive: {
    0: {
      items: 3,
    },
    576: {
      items: 4,
    },
    768: {
      items: 5,
    },
  },
});

mainCarousel
  .on("initialized.owl.carousel", function () {
    thumbCarousel.find(".owl-item").eq(0).addClass("selected-thumb");
  })
  .trigger("initialized.owl.carousel");

$(".gallery-thumbs").on("click", ".owl-item", function () {
  const index = $(this).index();
  mainCarousel.trigger("to.owl.carousel", [index, 300, true]);
  thumbCarousel.find(".owl-item").removeClass("selected-thumb");
  $(this).addClass("selected-thumb");
});

mainCarousel.on("changed.owl.carousel", function (event) {
  const index = event.item.index - event.relatedTarget._clones.length / 2;
  const currentIndex = (index + event.item.count) % event.item.count;
  thumbCarousel.find(".owl-item").removeClass("selected-thumb");
  thumbCarousel.find(".owl-item").eq(currentIndex).addClass("selected-thumb");
});

new QRCode(document.getElementById("qrcode-small"), {
  text: window.location.href,
  width: 96,
  height: 96,
  colorDark: "#15345B",
  colorLight: "#ffffff",
  correctLevel: QRCode.CorrectLevel.H,
});

const qrModal = document.getElementById("qrModal");
qrModal.addEventListener("shown.bs.modal", function () {
  document.getElementById("qrcode-large").innerHTML = "";
  new QRCode(document.getElementById("qrcode-large"), {
    text: window.location.href,
    width: 250,
    height: 250,
  });
});

document.getElementById("copyBtn").addEventListener("click", function () {
  navigator.clipboard.writeText(window.location.href).then(
    function () {
      notyf.success("Tautan disalin ke clipboard!");
    },
    function (err) {
      notyf.error("Gagal menyalin tautan: " + err);
    }
  );
});

document.getElementById("waShare").addEventListener("click", function () {
  const url = encodeURIComponent(window.location.href);
  window.open("https://wa.me/?text=" + url, "_blank");
});

document.getElementById("fbShare").addEventListener("click", function () {
  const url = encodeURIComponent(window.location.href);
  window.open("https://www.facebook.com/sharer/sharer.php?u=" + url, "_blank");
});

document.getElementById("twShare").addEventListener("click", function () {
  const url = encodeURIComponent(window.location.href);
  window.open("https://twitter.com/intent/tweet?url=" + url, "_blank");
});

document.getElementById("shopeeBtn").addEventListener("click", function () {
  window.open("https://shopee.co.id/inandao", "_blank");
});

document.addEventListener("keydown", function (e) {
  if (e.key === "s" || e.key === "S") {
    navigator.clipboard.writeText(window.location.href);
    notyf.success("Tautan disalin ke clipboard!");
  }
});

const maknaText = document.getElementById("maknaText");
const toggleMakna = document.getElementById("toggleMakna");

if (maknaText && toggleMakna) {
  let expanded = false;

  toggleMakna.addEventListener("click", function () {
    expanded = !expanded;
    maknaText.classList.toggle("expanded", expanded);
    toggleMakna.textContent = expanded ? "Lebih Pendek" : "Lihat Selengkapnya";
  });
}
