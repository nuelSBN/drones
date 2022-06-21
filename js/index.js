const menuBtn = document.querySelector("#menu__box");
const menuIcon = document.querySelector(".fa-bars-staggered");
const navbar = document.querySelector(".navbar");

menuBtn.addEventListener("click", () => {
  menuIcon.classList.toggle("fa-xmark");
  navbar.classList.toggle("mobile__nav");
});
