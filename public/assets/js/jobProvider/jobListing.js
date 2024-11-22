document.addEventListener('DOMContentLoaded', () => {
  const categories = document.querySelectorAll('.category');

  // Set the "Received" category as active on page load
  const receivedCategory = document.querySelector('.category[href*="received"]');
  if (receivedCategory) {
    receivedCategory.classList.add('active');
  }

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
