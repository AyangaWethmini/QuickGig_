<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/home/home.css">
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/empty.css">

<?php include APPROOT . '/views/components/navbar.php'; ?>

<style>
    .blurred {
        filter: blur(5px);
        transition: filter 0.3s ease-in-out;
    }

    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 30px;
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        width: 100%;
        max-width: 80vw;
        border-radius: 50px;
        /* PILL SHAPE */
        z-index: 1000;
        background: linear-gradient(to right, #f8f9ff, #e6ecff);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        height: 70px;
        border: 1px solid #dcdcdc;
    }

    .popup-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(15px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10000;
        animation: fadeIn 0.3s ease-in-out;
    }

    .popup-content {
        position: relative;
        background: #ffffff;
        padding: 30px;
        border-radius: 15px;
        width: 500px;
        max-width: 90%;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
        display: flex;
        flex-direction: column;
        align-items: center;
        animation: slideIn 0.4s ease-in-out;
    }

    .popup-content img {
        width: 100%;
        max-width: 400px;
        height: auto;
        margin: 20px 0;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .btns {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        gap: 20px;
    }

    .cancel-button,
    .learn-more {
        margin-top: 20px;
        padding: 12px 25px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
        font-size: 16px;
        transition: background 0.3s ease;
    }

    .cancel-button {
        background: #ff4d4f;
        color: #ffffff;
    }

    .cancel-button:hover {
        background: #ff7875;
    }

    .learn-more {
        background: #26a4ff;
        color: #ffffff;
    }

    .learn-more:hover {
        background: #4db8ff;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes slideIn {
        from {
            transform: translateY(-20px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
</style>
<div class="background-image" style="background-image: url('<?= ROOT ?>/assets/images/background.jpg');
;">

    <div class="home-announcement">
        <?php if (!empty($data['announcements']) && isset($data['announcements'][0])): ?>
            <div class="flex-row" style="margin-left:150px;">

                <img src="<?=ROOT?>/assets/images/alert.png" class="alert-icon">
                <div class="home-announcement-content">
                    <div class="home-announcement-date">
                     <?= htmlspecialchars($data['announcements'][0]->announcementDate) ?> 
                    </div>
                    <div class="home-announcement-text">
                        <?= htmlspecialchars($data['announcements'][0]->content) ?> 
                    </div>
                </div>
            </div>
        <?php else: ?>
            <p>No announcements available.</p>
        <?php endif; ?>
    </div>



    <div class="hero-section flex-row" style="margin-top:80px;">
        <div class="job-search">
            <h1 class="typography">Discover more than <br> <span>5000+ Jobs</span></h1>
            <svg class="hero-img" xmlns="http://www.w3.org/2000/svg" width="455" height="33" viewBox="0 0 455 33" fill="none" style="margin-top : 50px;">
                <path d="M9.7022 16.5071C13.2646 16.5071 16.9966 16.3386 20.559 16.1702C22.0857 16.1702 23.4428 16.0017 24.9696 16.0017C31.4158 15.6649 37.862 15.328 44.3082 14.9911C52.1115 14.6542 59.7452 14.1489 67.5485 13.812C78.5749 13.1383 89.6013 12.633 100.628 11.9592C103.172 11.7908 105.717 11.7908 108.261 11.6223C114.708 11.2854 121.154 10.9486 127.6 10.7801C134.046 10.4432 140.493 10.1064 146.939 9.93793C149.483 9.76949 152.028 9.60106 154.572 9.60106C164.751 9.26418 175.099 8.92729 185.277 8.59041C191.553 8.42197 197.83 8.25354 204.276 7.91666C206.821 7.91666 209.196 7.74821 211.74 7.74821C221.579 7.57977 231.588 7.41134 241.427 7.2429C251.266 7.07446 260.935 6.90602 270.774 6.73758C273.318 6.73758 275.863 6.73758 278.577 6.73758C285.023 6.73758 291.3 6.73758 297.746 6.73758C307.755 6.73758 317.594 6.73758 327.602 6.56914C330.826 6.56914 334.049 6.56914 337.272 6.56914C344.057 6.56914 350.843 6.56914 357.628 6.56914C358.137 6.56914 358.816 6.56914 359.325 6.56914C344.057 6.73758 328.62 6.90602 313.353 7.2429C306.907 7.41134 300.63 7.41134 294.184 7.57978C291.47 7.57978 288.586 7.57977 285.872 7.74821C276.542 7.91665 267.381 8.25353 258.051 8.42197C247.364 8.75885 236.677 8.92729 225.99 9.26417C224.124 9.26417 222.427 9.43261 220.561 9.43261C214.794 9.76949 209.196 9.93793 203.428 10.2748C191.893 10.7801 180.357 11.2854 168.822 11.7908C167.126 11.7908 165.429 11.9592 163.733 12.1276C158.135 12.4645 152.367 12.9698 146.769 13.3067C136.591 13.9805 126.582 14.6542 116.404 15.328C113.69 15.4964 110.806 15.8333 108.092 16.0017C101.646 16.5071 95.1994 17.0124 88.7532 17.6861C80.6106 18.3599 72.2983 19.0337 64.1558 19.7074C52.7901 20.7181 41.2547 21.7287 29.889 22.7393C27.1748 22.9078 24.4606 23.2446 21.5768 23.4131C16.6573 23.9184 11.7378 24.4237 6.81837 24.929C6.30945 24.929 5.80055 25.2659 5.80055 25.9397C5.80055 26.445 6.30945 26.9503 6.81837 26.9503C8.68438 26.9503 10.3808 27.1188 12.2468 27.1188C12.0771 27.6241 11.9075 28.1294 11.9075 28.6347C11.9075 30.4876 13.4342 32.1719 15.4699 32.1719C29.5498 31.3297 43.46 30.3191 57.5399 29.6453C69.7538 29.14 81.9677 28.4663 94.1816 27.9609C107.583 27.2872 121.154 26.6134 134.555 26.1081C138.796 25.9397 143.037 25.7712 147.278 25.4344C148.465 25.4344 149.653 25.2659 151.01 25.2659C172.724 24.7606 194.437 24.0868 216.151 23.5815C227.686 23.2446 239.391 22.9078 250.926 22.7393C255.167 22.5709 259.239 22.5709 263.48 22.4025C285.702 22.0656 307.924 21.7287 330.147 21.3918C339.647 21.2234 349.146 21.0549 358.646 20.8865C366.789 20.7181 374.931 20.7181 383.074 20.3812C389.859 20.2127 396.475 19.8759 403.261 19.7074C406.653 19.539 410.046 19.539 413.269 19.3705C420.903 18.8652 428.537 18.3599 436.17 17.8546C435.661 18.5283 435.661 19.539 435.831 20.2127C436.001 21.0549 436.51 21.7287 437.358 22.0656C438.036 22.4024 439.054 22.7393 439.733 22.4025C441.429 21.7287 443.125 21.0549 444.652 20.3812C444.652 20.3812 444.652 20.3812 444.482 20.3812C444.652 20.3812 444.652 20.2127 444.822 20.2127C444.991 20.2127 445.161 20.0443 445.161 20.0443H444.991C445.84 19.7074 446.688 19.3705 447.706 18.8652C448.554 18.5283 449.572 18.023 450.42 17.6861C451.438 17.1808 452.286 16.6755 453.304 16.1702C454.321 15.6649 455 14.3174 455 13.1383C455 12.4645 454.83 11.9592 454.491 11.2855C454.152 10.6117 453.304 9.7695 452.455 9.60106C451.607 9.43262 450.759 9.26417 449.911 9.26417C449.741 9.26417 449.572 9.26417 449.402 9.26417C448.893 9.26417 448.215 9.26417 447.706 9.43261C446.349 9.60105 445.161 9.76949 443.804 9.76949C442.786 9.76949 441.768 9.93793 440.581 9.93793C437.697 10.1064 434.983 10.2748 432.099 10.6117C431.42 10.6117 430.572 10.7801 429.894 10.7801C430.233 10.4432 430.403 10.1064 430.403 9.76949C430.572 9.43262 430.572 9.09574 430.572 8.75886C430.572 8.59042 430.572 8.25354 430.742 8.0851C430.742 7.74822 430.742 7.41134 430.572 7.2429C430.572 7.2429 430.742 7.24291 430.742 7.07447C431.251 6.73759 431.76 6.4007 432.099 5.72694C432.438 5.22163 432.608 4.54787 432.608 3.87411C432.608 3.20036 432.438 2.69504 432.099 2.02128C431.929 1.85284 431.76 1.51596 431.59 1.34752C431.081 0.842202 430.572 0.673763 430.063 0.505324C429.045 0.168445 427.858 0 426.671 0C425.653 0 424.805 0 423.787 0C422.43 0 421.073 0 419.715 0C417.849 0 415.814 0 413.948 0C408.859 0 403.77 0 398.68 0C393.931 0 389.011 0 384.261 0C379.851 0 375.61 0 371.199 0C353.727 0 336.424 0.168447 318.951 0.336887C305.889 0.505326 292.827 0.67376 279.765 0.67376C273.997 0.67376 268.06 0.842195 262.292 1.01063C249.23 1.34751 236.168 1.51595 223.106 1.85283C219.374 1.85283 215.642 2.02128 211.91 2.02128C209.705 2.02128 207.669 2.18972 205.464 2.18972C192.571 2.69504 179.679 3.20036 166.786 3.70568C162.885 3.87412 158.983 4.04255 154.912 4.21099C152.706 4.21099 150.501 4.37943 148.296 4.54787C135.403 5.22163 122.681 5.89538 109.788 6.56914C103.172 6.90602 96.5565 7.24289 89.9406 7.74821C78.5749 8.42197 67.2092 9.09573 56.0132 9.93793C46.1742 10.6117 36.3353 11.117 26.4963 11.6223C24.9696 11.7908 23.4428 11.7908 21.7464 11.9592C19.2019 12.1276 16.6573 12.1276 14.1128 12.2961C11.9075 12.4645 9.7022 12.4645 7.32728 12.4645C7.15764 11.9592 6.47909 11.4539 5.97018 11.4539C4.44345 11.6223 3.08635 11.7908 1.55961 11.9592C0.881065 11.9592 0.202516 12.2961 0.0328783 13.1383C-0.136759 13.9805 0.372152 14.8227 1.0507 14.9911C1.72925 15.1596 2.23816 15.328 2.91671 15.4964C3.59526 15.6649 4.10417 15.6649 4.78272 15.6649C6.47909 16.3386 8.00583 16.3386 9.7022 16.5071ZM406.653 10.9486C408.689 10.9486 410.894 10.9486 412.93 10.9486C413.1 11.4539 413.439 11.7908 413.778 12.1276C412.93 12.1276 412.082 12.2961 411.403 12.2961C409.876 12.2961 408.35 12.4645 406.823 12.4645C400.038 12.633 393.422 12.9698 386.636 13.1383C383.583 13.3067 380.529 13.4752 377.476 13.4752C372.726 13.4752 367.806 13.6436 363.057 13.6436C352.03 13.812 341.173 13.9805 330.147 14.1489C308.773 14.4858 287.568 14.8227 266.194 15.1596C250.926 15.328 235.659 15.8333 220.392 16.3386C197.491 17.0124 174.42 17.5177 151.519 18.1915C146.939 18.3599 142.359 18.5283 137.778 18.8652C124.716 19.539 111.654 20.0443 98.5921 20.7181C85.8693 21.3918 72.9769 21.8971 60.2541 22.5709C59.0666 22.5709 57.8792 22.7393 56.6917 22.7393C60.0845 22.4025 63.6468 22.234 67.0396 21.8971C79.0838 21.0549 91.1281 20.0443 103.172 19.2021C107.413 18.8652 111.654 18.5283 115.725 18.1915C117.931 18.023 120.136 17.8546 122.172 17.8546C134.725 17.1808 147.278 16.3386 159.831 15.6649C162.206 15.4964 164.751 15.328 167.126 15.1596C170.688 14.9911 174.25 14.8227 177.643 14.8227C190.536 14.3174 203.428 13.812 216.32 13.3067C219.204 13.1383 222.088 13.1383 224.802 12.9698C225.481 12.9698 226.329 12.9698 227.008 12.9698C229.043 12.9698 231.079 12.9698 232.945 12.8014C245.837 12.4645 258.899 12.2961 271.792 11.9592C277.729 11.7908 283.666 11.6223 289.604 11.6223C308.773 11.4539 328.111 11.2854 347.28 11.117C367.467 11.117 387.145 11.117 406.653 10.9486Z" fill="#26A4FF" />
            </svg>
            <div class="randowm-section">
                <p class="hero-text text-grey">
                    Great platform for the job seeker that is looking to <br>earn an extra income
                </p>
            </div>


        </div>
        <div class="hero-img">
            <img src="<?= ROOT ?>/assets/images/hero.png" alt="">
        </div>

    </div>


    <div class="carousel-container">
        <div class="carousel-slide" id="carousel-slide">
            <div class="carousel-slide-img" style="background-image: url('<?= ROOT ?>/assets/images/carousel1.jpg');">
                <div class="carousel-caption">
                    <h2>Unlock Flexibility, Earn on Your Terms</h2>
                    <p>Discover part-time job opportunities that fit your schedule. Whether you're looking for extra income or gaining experience, we've got something for you. Work when it’s convenient for you, and get paid for your time.</p>
                </div>
            </div>
            <div class="carousel-slide-img" style="background-image: url('<?= ROOT ?>/assets/images/carousel2.jpg');">
                <div class="carousel-caption">
                    <h2>Your Next Job is Just a Click Away</h2>
                    <p>Find quick, flexible part-time jobs in your area. With a wide variety of roles, you're just one click away from starting your next opportunity. Join now and explore new ways to earn.</p>
                </div>
            </div>
            <div class="carousel-slide-img" style="background-image: url('<?= ROOT ?>/assets/images/carousel3.jpg');">
                <div class="carousel-caption">
                    <h2>Work Smart, Earn More</h2>
                    <p>With our easy-to-use platform, finding the perfect part-time job is simpler than ever. Build your skills, grow your network, and earn at your own pace. Start today and unlock the potential of part-time work!</p>
                </div>
            </div>
        </div>
        <button class="carousel-btn prev" onclick="moveSlide(-1)">❮</button>
        <button class="carousel-btn next" onclick="moveSlide(1)">❯</button>
    </div>

    <div class="featured flex-col">
        <div style="display: flex; justify-content:space-between;">
            <p class="typography" style="font-size: 48px;">
                Featured <span>jobs</span>
            </p>
        </div>
        <section class="job-marquee-container">
            <h2 class="job-marquee-title">🔥 Latest Job Opportunities</h2>
            <div class="job-marquee-track">
                <?php for ($i = 0; $i < 2; $i++): // Repeat for infinite loop 
                ?>
                    <?php foreach ($jobs as $job): ?>
                        <div class="job-card">
                            <img class="job-photo"
                                src="<?= !empty($job->pp) ? 'data:image/jpeg;base64,' . base64_encode($job->pp) : ROOT . '/assets/images/default.jpg' ?>"
                                alt="Profile Photo">
                            <div class="job-info">
                                <h3><?= htmlspecialchars($job->name); ?></h3>
                                <p class="job-title"><?= htmlspecialchars($job->jobTitle); ?></p>
                                <p class="job-meta">Job ID: <?= htmlspecialchars($job->jobID); ?></p>
                                <p class="job-date"><?= htmlspecialchars($job->datePosted); ?> | <?= htmlspecialchars($job->timePosted); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endfor; ?>
            </div>
        </section>
    </div>
    <div class="featured flex-col">
        <div style="display: flex; justify-content:space-between;">
            <p class="typography" style="font-size: 48px;">
                Featured <span>Availabilities</span>
            </p>
        </div>
        <section class="job-marquee-container2">
            <h2 class="job-marquee-title">🔥 Latest Employee Opportunities</h2>
            <div class="job-marquee-track2">
                <?php for ($i = 0; $i < 2; $i++): // Repeat for infinite loop 
                ?>
                    <?php foreach ($employees as $job): ?>
                        <div class="job-card">
                            <img class="job-photo"
                                src="<?= !empty($job->pp) ? 'data:image/jpeg;base64,' . base64_encode($job->pp) : ROOT . '/assets/images/default.jpg' ?>"
                                alt="Profile Photo">
                            <div class="job-info">
                                <h3><?= htmlspecialchars($job->fname . ' ' . $job->lname); ?></h3>
                                <p class="job-title"><?= htmlspecialchars($job->description); ?></p>
                                <p class="job-meta">Job ID: <?= htmlspecialchars($job->availableID); ?></p>
                                <p class="job-date"><?= htmlspecialchars($job->datePosted); ?> | <?= htmlspecialchars($job->timePosted); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endfor; ?>
            </div>
        </section>
    </div>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-logo-section">
                <img src="<?= ROOT ?>/assets/images/QuickGiglLogo.png" alt="QuickGig Logo" class="footer-logo" />
                <p class="footer-text">
                    Great platform for job seekers who<br>
                    are passionate about startups. Find<br>
                    your dream job easier.
                </p>
            </div>

            <div class="footer-links">
                <a href="<?= ROOT ?>/home/aboutUs">About Us</a>
                <a href="<?= ROOT ?>/home/contact">Contact Us</a>
            </div>
        </div>

        <hr class="footer-divider">
        <p class="copyright">&copy; 2024 QuickGig. All rights reserved.</p>
    </footer>

</div>



<?php

if (
    isset($_SESSION['user_role']) &&
    $_SESSION['user_role'] != 0 &&
    $_SESSION['user_role'] != 1 &&
    isset($_SESSION['plan_id']) &&
    $_SESSION['plan_id'] == -1
) {
    $lastAdTime = $_SESSION['last_ad_time'] ?? 0;
    $currentTime = time();
    $timeDifference = $currentTime - $lastAdTime;

    
    if ($timeDifference >= 1200) {
        $_SESSION['last_ad_time'] = $currentTime;
        $ad = $data['advertisements'][0] ?? null;
?>
        <div id="ad-popup" class="popup-overlay">
            <div class="popup-content">
                <?php if ($ad && !empty($ad->img)): ?>
                    <?php
                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                    $mimeType = $finfo->buffer($ad->img);
                    ?>
                    <a href="<?= $ad->link ?>" target="_blank">
                        <img src="data:<?= $mimeType ?>;base64,<?= base64_encode($ad->img) ?>" alt="Ad Image" style="width: 200px; height: 200px;">
                        <p><?php htmlspecialchars($ad->adTitle); ?></p>
                    </a>
                    <script>
                       
                        recordAdView(<?= $ad->advertisementId ?>);
                    </script>
                <?php else: ?>
                    <img src="<?= ROOT ?>/assets/images/placeholder.jpg" alt="No image available">
                    <!-- <p><?php htmlspecialchars($ad->adTitle); ?></p> -->
                <?php endif; ?>
                <div class="btns">
                    <button class="cancel-button" onclick="closePopup()">Cancel</button>
                    <button class="learn-more btn btn-accent" onclick="recordAdClick(event, <?= $ad->advertisementID ?>, '<?= $ad->link ?>')">Learn More</button>
                </div>
            </div>
        </div>
        <script>
            
            recordAdView(<?= $ad->advertisementId ?>);
        </script>
<?php
    }
}
?>

<?php require APPROOT . '/views/inc/footer.php'; ?>

<script>
    // function hideSubscriptionPopup() {
    //     document.querySelector('.sub-background').style.display = 'none';
    // }

    function recordAdClick(event, adId, adLink) {
        event.preventDefault();

        
        fetch(`<?php echo ROOT ?>/manager/click/${adId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                
                if (adLink) {
                    window.open(adLink, '_blank');
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function recordAdView(adId) {
        if (adId && !isNaN(adId)) {
            fetch(`<?php echo ROOT ?>/manager/adView/${adId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('View recorded successfully:', data.message);
                    } else {
                        console.error('Failed to record view:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        } else {
            console.error('Invalid ad ID');
        }
    }

    const popup = document.getElementById('ad-popup');
    const content = document.getElementById('main-content');

    function closePopup() {
        if (popup) popup.style.display = 'none';
        if (content) content.classList.remove('blurred');
    }

    window.onload = function() {
        if (popup) {
            popup.style.display = 'flex';
            if (content) content.classList.add('blurred');
            setTimeout(() => {
                closePopup();
            }, 10000);
        }
    };
</script>
<script>
    let currentSlide = 0;
    const slideContainer = document.getElementById('carousel-slide');
    const slides = slideContainer.children;
    const totalSlides = slides.length;

    // Dynamically set width of container and each slide
    slideContainer.style.width = `${totalSlides * 100}%`;
    for (let slide of slides) {
        slide.style.width = `${100 / totalSlides}%`;
    }

    // Slide update function
    function updateSlide() {
        slideContainer.style.transform = `translateX(-${currentSlide * (100 / totalSlides)}%)`;
    }

    // Move slide by direction (+1 or -1)
    function moveSlide(direction) {
        currentSlide = (currentSlide + direction + totalSlides) % totalSlides;
        updateSlide();
        resetAutoSlide();
    }

    // Auto slide every 5 seconds
    let autoSlide = setInterval(() => moveSlide(1), 5000);

    function resetAutoSlide() {
        clearInterval(autoSlide);
        autoSlide = setInterval(() => moveSlide(1), 5000);
    }

    // Swipe support for mobile devices
    let startX = 0;
    slideContainer.addEventListener('touchstart', (e) => {
        startX = e.touches[0].clientX;
    });

    slideContainer.addEventListener('touchend', (e) => {
        const endX = e.changedTouches[0].clientX;
        if (startX - endX > 50) moveSlide(1); // swipe left
        else if (endX - startX > 50) moveSlide(-1); // swipe right
    });
</script>