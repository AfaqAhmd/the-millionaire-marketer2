document.addEventListener("DOMContentLoaded", () => {
  const menuToggle = document.getElementById("menu-toggle");
  const mobileMenu = document.getElementById("mobile-menu");

  // Toggle menu visibility on click
  menuToggle.addEventListener("click", () => {
    mobileMenu.classList.toggle("open");
  });

  // Optional: Close menu when clicking outside
  document.addEventListener("click", (event) => {
    if (!menuToggle.contains(event.target) && !mobileMenu.contains(event.target)) {
      mobileMenu.classList.remove("open");
    }
  });
});


document.querySelectorAll('nav ul li a').forEach(link => {
  if (link.href === window.location.href) {
      link.classList.add('active');
  } else {
      link.classList.remove('active');
  }
});