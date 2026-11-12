const menuToggle = document.querySelector("#menu-toggle");
const sidebar = document.querySelector("#sidebar");
const sidebarBackdrop = document.querySelector("#sidebar-backdrop");

function closeSidebar() {
  sidebar.classList.remove("open");
  sidebarBackdrop.classList.remove("visible");
  menuToggle.setAttribute("aria-expanded", "false");
}

menuToggle.addEventListener("click", () => {
  const isOpen = sidebar.classList.toggle("open");
  sidebarBackdrop.classList.toggle("visible", isOpen);
  menuToggle.setAttribute("aria-expanded", String(isOpen));
});

sidebarBackdrop.addEventListener("click", closeSidebar);
sidebar.querySelectorAll(".nav-link").forEach((link) => {
  link.addEventListener("click", closeSidebar);
});
