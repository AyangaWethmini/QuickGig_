<link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/ads.css">

<!-- Add this new CSS for the popup -->
<style>
    .ad-popup {
        position: fixed;
        bottom: -400px; /* Start hidden below viewport */
        left: 0;
        right: 0;
        max-width: 800px;
        margin: 0 auto;
        background: white;
        box-shadow: 0 -2px 20px rgba(0,0,0,0.2);
        border-radius: 10px 10px 0 0;
        z-index: 1000;
        transition: bottom 0.5s ease-in-out;
        padding: 20px;
        box-sizing: border-box;
    }
    
    .ad-popup.show {
        bottom: 0; /* Show at bottom of viewport */
    }
    
    .popup-close {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 24px;
        cursor: pointer;
        color: #666;
        background: none;
        border: none;
    }
    
    .popup-close:hover {
        color: #000;
    }
    
    .popup-content {
        position: relative;
    }
    
    /* Override some styles for popup layout */
    .popup-content .promo-item-box {
        width: 100%;
        margin: 0;
    }
    
    .popup-content .promo-pair-container {
        flex-direction: column;
    }
</style>

<!-- Popup container (initially hidden) -->
<div class="ad-popup" id="adPopup">
    <button class="popup-close" onclick="closePopup()">&times;</button>
    <div class="popup-content">


    heloooooooo
        <!-- Single ad will be shown here -->
        <div class="promo-item-box" id="popupAdContainer">
            <!-- Ad content will be inserted here by JavaScript -->
        </div>
    </div>
</div>

<script>
// Track viewed ads to prevent duplicate counting
const viewedAds = new Set();
let popupTimeout;
let adRefreshInterval;

// Function to get a random ad
function getRandomAd() {
    const ads = <?= json_encode($advertisements) ?>;
    return ads[Math.floor(Math.random() * ads.length)];
}

// Function to display an ad in the popup
function displayAdInPopup(ad) {
    const container = document.getElementById('popupAdContainer');
    
    // Clear previous ad
    container.innerHTML = '';
    
    // Set ad ID for tracking
    container.dataset.adId = ad.advertisementID;
    
    // Create ad HTML
    let adHtml = `
    <div class="promo-visual">
        ${ad.img ? 
            `<img src="data:${getMimeType(ad.img)};base64,${arrayBufferToBase64(ad.img)}" 
                  alt="${escapeHtml(ad.adTitle)}" 
                  class="promo-image">` : 
            `<img src="<?= ROOT ?>/assets/images/placeholder.jpg" 
                  alt="No image available" 
                  class="promo-image">`
        }
    </div>
    <div class="promo-info-panel">
        <h3 class="promo-heading">${escapeHtml(ad.adTitle)}</h3>
        <p class="promo-text">${escapeHtml(ad.adDescription)}</p>
        <div class="promo-actions">
            <a href="${escapeHtml(ad.link)}" 
               class="action-btn primary-btn" 
               target="_blank" 
               rel="noopener noreferrer"
               onclick="trackAdClick(${ad.advertisementID}); return true;">
                Discover More
            </a>
        </div>
    </div>
`;

// Add this helper function to properly convert ArrayBuffer to base64
function arrayBufferToBase64(buffer) {
    let binary = '';
    const bytes = new Uint8Array(buffer);
    const len = bytes.byteLength;
    for (let i = 0; i < len; i++) {
        binary += String.fromCharCode(bytes[i]);
    }
    return window.btoa(binary);
}
    
    container.innerHTML = adHtml;
    
    // Track the view
    trackAdView(container);
}

// Helper function to get MIME type (simplified version)
function getMimeType(buffer) {
    // In a real implementation, you would detect the actual MIME type
    return 'image/jpeg'; // Default to JPEG for this example
}

// Helper function to safely encode binary data to Base64
function encodeToBase64(buffer) {
    let binary = '';
    const bytes = new Uint8Array(buffer);
    for (let i = 0; i < bytes.length; i++) {
        binary += String.fromCharCode(bytes[i]);
    }
    return btoa(binary);
}

// Helper function to escape HTML
function escapeHtml(unsafe) {
    return unsafe
         .replace(/&/g, "&amp;")
         .replace(/</g, "&lt;")
         .replace(/>/g, "&gt;")
         .replace(/"/g, "&quot;")
         .replace(/'/g, "&#039;");
}

// Track ad view
function trackAdView(adElement) {
    const adId = adElement.dataset.adId;
    if (viewedAds.has(adId)) return;
    
    viewedAds.add(adId);
    
    // Use beacon API for reliable tracking
    const data = new Blob([JSON.stringify({ adID: adId })], { type: 'application/json' });
    
    if (navigator.sendBeacon) {
        navigator.sendBeacon(`<?= ROOT ?>/manager/incrementAdView/${adId}`, data);
    } else {
        fetch(`<?= ROOT ?>/manager/incrementAdView/${adId}`, {
            method: 'POST',
            body: JSON.stringify({ adID: adId }),
            headers: { 'Content-Type': 'application/json' },
            keepalive: true
        }).catch(() => {});
    }
}

// Click tracking
function trackAdClick(adId) {
    const data = new Blob([JSON.stringify({ adID: adId })], { type: 'application/json' });
    
    if (navigator.sendBeacon) {
        navigator.sendBeacon(`<?= ROOT ?>/manager/incrementAdClick/${adId}`, data);
    } else {
        fetch(`<?= ROOT ?>/manager/incrementAdClick/${adId}`, {
            method: 'POST',
            body: JSON.stringify({ adID: adId }),
            headers: { 'Content-Type': 'application/json' },
            keepalive: true
        }).catch(() => {});
    }
    return true; // Allow default link behavior
}

// Show the popup with a random ad
function showPopupWithAd() {
    const popup = document.getElementById('adPopup');
    const ad = getRandomAd();
    
    displayAdInPopup(ad);
    popup.classList.add('show');
    
    // Set timeout to show next ad in 15 minutes (900000 ms)
    adRefreshInterval = setInterval(() => {
        const newAd = getRandomAd();
        displayAdInPopup(newAd);
    }, 900000);
}

// Close the popup
function closePopup() {
    const popup = document.getElementById('adPopup');
    popup.classList.remove('show');
    
    // Clear any pending timeouts/intervals
    clearTimeout(popupTimeout);
    clearInterval(adRefreshInterval);
}

// Initialize the popup when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Show popup after a short delay (1 second)
    popupTimeout = setTimeout(showPopupWithAd, 1000);
    
    // Close popup when clicking outside of it
    document.addEventListener('click', function(e) {
        const popup = document.getElementById('adPopup');
        if (!popup.contains(e.target) && e.target.className !== 'popup-close') {
            closePopup();
        }
    });
});

// Also close when pressing Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closePopup();
    }
});
</script>