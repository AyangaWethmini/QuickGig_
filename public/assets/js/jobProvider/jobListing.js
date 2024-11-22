document.addEventListener('DOMContentLoaded', () => {
  const categories = document.querySelectorAll('.category');

  // Function to set the active category based on the current URL
  const setActiveCategory = () => {
    const currentURL = window.location.href;
    categories.forEach(category => {
      const categoryHref = category.getAttribute('href');
      if (currentURL.includes(categoryHref) && categoryHref !== '#received') {
        category.classList.add('active');
      } else {
        category.classList.remove('active');
      }
    });
  };

  // Set the active category on page load
  setActiveCategory();

  categories.forEach(category => {
    category.addEventListener('click', () => {
      categories.forEach(cat => cat.classList.remove('active'));
      category.classList.add('active');
    });
  });
});

const moreOptionsButton = document.querySelector('.more-options');
const menuOverlay = document.querySelector('.menu-overlay');

moreOptionsButton.addEventListener('click', () => {
  menuOverlay.classList.remove('hidden');
});

menuOverlay.addEventListener('click', (e) => {
  if (e.target === menuOverlay) {
    menuOverlay.classList.add('hidden');
  }
});