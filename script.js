var swiper = new Swiper(".mySwiperpoli", {
  slidesPerView: 1,
  spaceBetween: 10,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  breakpoints: {
    1024: {
      slidesPerView: 3,
      spaceBetween: 20,
    },
  },
});

var swiper = new Swiper(".mySwiperdokter", {
  slidesPerView: 1,
  spaceBetween: 10,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextEl: ".swiper-button-next-dokter",
    prevEl: ".swiper-button-prev-dokter",
  },
  breakpoints: {
    1024: {
      slidesPerView: 4,
      spaceBetween: 50,
    },
  },
});

function showLoginMessage(event) {
  event.preventDefault(); // Mencegah perpindahan halaman
  const messageBox = document.getElementById("login-message");
  messageBox.style.display = "block";
}

