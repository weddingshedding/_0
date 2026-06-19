
window.addEventListener("load", () => {
  document.querySelector(".preloader")?.classList.add("hide");
});

const glow = document.querySelector(".cursor-glow");
document.addEventListener("mousemove", (e) => {
  if(glow){
    glow.style.left = e.clientX + "px";
    glow.style.top = e.clientY + "px";
  }
});

document.querySelectorAll(".tilt").forEach((card) => {
  card.addEventListener("mousemove", (e) => {
    const r = card.getBoundingClientRect();
    const x = e.clientX - r.left;
    const y = e.clientY - r.top;
    const rx = ((y / r.height) - .5) * -12;
    const ry = ((x / r.width) - .5) * 12;
    card.style.transform = `rotateX(${rx}deg) rotateY(${ry}deg) translateY(-4px)`;
  });
  card.addEventListener("mouseleave", () => {
    card.style.transform = "rotateX(0deg) rotateY(0deg)";
  });
});

const lightbox = document.querySelector(".lightbox");
const lightImg = document.querySelector(".lightbox img");
document.querySelectorAll(".photo-card").forEach(card => {
  card.addEventListener("click", () => {
    lightImg.src = card.dataset.src;
    lightbox.classList.add("show");
    lightbox.setAttribute("aria-hidden","false");
  });
});
document.querySelector(".close")?.addEventListener("click", () => {
  lightbox.classList.remove("show");
  lightbox.setAttribute("aria-hidden","true");
});
lightbox?.addEventListener("click", (e) => {
  if(e.target === lightbox) lightbox.classList.remove("show");
});
