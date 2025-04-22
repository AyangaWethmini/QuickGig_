<link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/ads.css">

<div class="slideshow-container">
    <?php 
    // Shuffle advertisements randomly
    $shuffledAds = $advertisements;
    shuffle($shuffledAds);
    
    // Handle circular pairing if the number of ads is odd
    $advertisementsCount = count($shuffledAds);
    if ($advertisementsCount % 2 !== 0) {
        // Add random ad to make it even (not always first one)
        $shuffledAds[] = $shuffledAds[array_rand($shuffledAds)];
    }

    // Group ads into randomized pairs
    $adPairs = array_chunk($shuffledAds, 2);

    foreach ($adPairs as $index => $pair): ?>
        <div class="mySlides <?= $index === 0 ? 'active-slide' : '' ?>">
            <div class="promo-pair-container">
                <?php foreach ($pair as $ad): ?>
                    <div class="promo-item-box" data-ad-id="<?= $ad->advertisementID ?>">
                        <div class="promo-visual">
                            <?php if ($ad->img): ?>
                                <?php 
                                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                                    $mimeType = $finfo->buffer($ad->img);
                                ?>
                                <img src="data:<?= $mimeType ?>;base64,<?= base64_encode($ad->img) ?>" 
                                     alt="<?= htmlspecialchars($ad->adTitle) ?>" 
                                     class="promo-image">
                            <?php else: ?>
                                <img src="<?= ROOT ?>/assets/images/placeholder.jpg" 
                                     alt="No image available" 
                                     class="promo-image">
                            <?php endif; ?>
                        </div>
                        <div class="promo-info-panel">
                            <h3 class="promo-heading"><?= htmlspecialchars($ad->adTitle) ?></h3>
                            <p class="promo-text"><?= htmlspecialchars($ad->adDescription) ?></p>
                            <div class="promo-actions">
                                <a href="<?= htmlspecialchars($ad->link) ?>" 
                                   class="action-btn primary-btn" 
                                   target="_blank" 
                                   rel="noopener noreferrer"
                                   onclick="trackAdClick(<?= $ad->advertisementID ?>)">
                                    Discover More
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Next and previous buttons -->
    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
    <a class="next" onclick="plusSlides(1)">&#10095;</a>
</div>

<!-- Dots/circles -->
<div style="text-align:center; margin-top: 10px;">
    <?php foreach ($adPairs as $index => $pair): ?>
        <span class="dot" onclick="currentSlide(<?= $index + 1 ?>)"></span>
    <?php endforeach; ?>
</div>

<script>
// Track viewed ads to prevent duplicate counting
const viewedAds = new Set();

// Silent ad view tracking
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

let slideIndex = 1;
let slideInterval;

// Initialize the slideshow
function showSlides(n) {
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("dot");

    if (n > slides.length) { slideIndex = 1; }
    if (n < 1) { slideIndex = slides.length; }

    // Hide all slides
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
        slides[i].classList.remove("active-slide");
    }

    // Remove active class from all dots
    for (let i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active-dot", "");
    }

    // Show the current slide and mark the dot as active
    slides[slideIndex - 1].style.display = "block";
    slides[slideIndex - 1].classList.add("active-slide");
    dots[slideIndex - 1].className += " active-dot";

    // Track view for the current slide's ads
    const currentSlideAds = slides[slideIndex - 1].querySelectorAll('[data-ad-id]');
    currentSlideAds.forEach(ad => {
        trackAdView(ad);
    });

    // Animation
    for (let i = 0; i < slides.length; i++) {
        if (i === slideIndex - 1) {
            slides[i].style.transform = "translateX(0)";
        } else if (i < slideIndex - 1) {
            slides[i].style.transform = "translateX(-100%)";
        } else {
            slides[i].style.transform = "translateX(100%)";
        }
    }
}

// Change slide
function plusSlides(n) {
    clearInterval(slideInterval); // Pause auto-advance
    showSlides(slideIndex += n);
    slideInterval = setInterval(() => plusSlides(1), 5000); // Resume
}

// Set the current slide
function currentSlide(n) {
    clearInterval(slideInterval);
    showSlides(slideIndex = n);
    slideInterval = setInterval(() => plusSlides(1), 5000);
}

// Start the slideshow
document.addEventListener('DOMContentLoaded', function() {
    showSlides(slideIndex);
    
    // Auto-play the slideshow every 5 seconds
    slideInterval = setInterval(() => plusSlides(1), 5000);
    
    // Track initial slide views
    const initialSlide = document.querySelector('.mySlides.active-slide');
    if (initialSlide) {
        const initialAds = initialSlide.querySelectorAll('[data-ad-id]');
        initialAds.forEach(ad => {
            trackAdView(ad);
        });
    }
});
</script>