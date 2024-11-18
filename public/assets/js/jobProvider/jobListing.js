document.addEventListener('DOMContentLoaded', () => {
  const categories = document.querySelectorAll('.category');

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
