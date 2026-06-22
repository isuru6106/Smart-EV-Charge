const heroImages = [

  "https://electronicsbuzz.in/wp-content/uploads/2025/09/TOP-10-Leading-EV-Charging-Station-Companies-in-India.jpg",

  "https://autovista24.autovistagroup.com/wp-content/uploads/sites/5/2021/09/what-is-an-ev-1024x653.jpg",

  "https://adaderanaenglish.s3.amazonaws.com/1738381276-electric-6.jpg",

  "https://greenearth-international.org/wp-content/uploads/2023/12/hero-bg2.jpg"

];

document.addEventListener("DOMContentLoaded", () => {

  const slider = document.querySelector(".hero-bg-slider");

  if (!slider) {
    console.error("hero-bg-slider div not found");
    return;
  }

  let currentImage = 0;

  // Preload images
  heroImages.forEach((img) => {
    const image = new Image();
    image.src = img;
  });

  function changeHeroBackground() {

    slider.style.opacity = "0.4";

    setTimeout(() => {

      slider.style.backgroundImage =
        `url("${heroImages[currentImage]}")`;

      slider.style.opacity = "1";

      currentImage++;

      if (currentImage >= heroImages.length) {
        currentImage = 0;
      }

    }, 400);
  }

  // First image
  slider.style.backgroundImage =
    `url("${heroImages[0]}")`;

  // Smooth transition
  slider.style.transition =
    "background-image 1.5s ease-in-out, opacity 0.8s ease";

  // Start changing
  setInterval(changeHeroBackground, 5000);

});