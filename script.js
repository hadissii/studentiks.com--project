document.addEventListener("DOMContentLoaded", () => {

  /* ========== THEME TOGGLE ========== */
  const themeToggle = document.getElementById("themeToggle");
  const body = document.body;

  if (localStorage.getItem("theme") === "dark") {
    body.classList.replace("light", "dark");
    themeToggle.textContent = "Light Mode";
  } else {
    body.classList.add("light");
    themeToggle.textContent = "Dark Mode";
  }

  themeToggle.addEventListener("click", () => {
    body.classList.toggle("dark");
    body.classList.toggle("light");
    const isDark = body.classList.contains("dark");
    themeToggle.textContent = isDark ? "Light Mode" : "Dark Mode";
    localStorage.setItem("theme", isDark ? "dark" : "light");
  });

  /* ========== MOBILE MENU ========== */
  const hamburgerBtn = document.getElementById("hamburgerBtn");
  const mobileMenu = document.getElementById("mobileMenu");

  hamburgerBtn.addEventListener("click", () => {
    hamburgerBtn.classList.toggle("active");
    mobileMenu.classList.toggle("active");
  });

});

