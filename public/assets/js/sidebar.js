document.addEventListener('DOMContentLoaded', () => {
    const sidebarItems = document.querySelectorAll('.sidebar-item');

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

        if (currentURL.includes('/jobListing_') ||currentURL.includes('/org_jobListing_') ) {
            const jobListingItem = document.querySelector('.sidebar-item[href*="jobListing_"]' );
            if (jobListingItem) {
                jobListingItem.classList.add('active');
            }
        }
    };

    setActiveSidebarItem();

    sidebarItems.forEach(item => {
        item.addEventListener('click', () => {
            sidebarItems.forEach(i => i.classList.remove('active'));
            item.classList.add('active');
        });
    });
});