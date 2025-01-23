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


const form = document.getElementById('myform');
const thankYouMessage = document.getElementById('thank-you');

form.addEventListener('submit', function (event) {
  event.preventDefault(); // Prevent form submission from refreshing the page
  thankYouMessage.style.display = 'block'; // Show the thank-you message
  form.reset(); // Optional: Reset the form fields
});