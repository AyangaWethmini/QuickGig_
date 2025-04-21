document.addEventListener('DOMContentLoaded', () => {
    const sidebarItems = document.querySelectorAll('.sidebar-item');

    // Function to set the active sidebar item based on the current URL
    const setActiveSidebarItem = () => {
        const currentURL = window.location.href;
        sidebarItems.forEach(item => {
            const itemHref = item.getAttribute('href');
            if (currentURL.includes(itemHref)) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });
    };

    // Set the active sidebar item on page load
    setActiveSidebarItem();

    // Add click event listeners to toggle active class
    sidebarItems.forEach(item => {
        item.addEventListener('click', () => {
            sidebarItems.forEach(i => i.classList.remove('active'));
            item.classList.add('active');
        });
    });
});