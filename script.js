document.addEventListener("DOMContentLoaded", () => {

  const toggle = document.getElementById("themeToggle");
  const body = document.body;

  // Load theme
  const savedTheme = localStorage.getItem("theme");
  if (savedTheme === "dark") {
    body.classList.add("dark");
    toggle.checked = true;
  } else {
    body.classList.add("light");
  }

  // Switch toggle
  toggle.addEventListener("change", () => {
    body.classList.toggle("dark");
    body.classList.toggle("light");

    if (toggle.checked) {
      localStorage.setItem("theme", "dark");
    } else {
      localStorage.setItem("theme", "light");
    }
  });

  /* ========== MOBILE MENU ========== */
  const hamburgerBtn = document.getElementById("hamburger");
  const mobileMenu = document.getElementById("mobileMenu");

  hamburgerBtn.addEventListener("click", () => {
    mobileMenu.classList.toggle("active");
  });

});
