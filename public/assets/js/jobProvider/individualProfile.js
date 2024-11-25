document.addEventListener('DOMContentLoaded', () => {
    const categories = document.querySelectorAll('.role-btn');
  
    // Function to set the active category based on the current URL
    const setActiveCategory = () => {
      const currentURL = window.location.href;
      categories.forEach(category => {
        const categoryHref = category.getAttribute('href');
        if (currentURL.includes(categoryHref) && categoryHref !== '#individualProfile') {
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