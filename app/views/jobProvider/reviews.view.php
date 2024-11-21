<?php require APPROOT . '/views/inc/header.php'; ?>

<link rel="stylesheet" href="<?=ROOT?>/assets/css/JobProvider/reviews.css">
<?php require APPROOT . '/views/components/navbar.php'; ?>

<div class="wrapper flex-row">
    <?php require APPROOT . '/views/jobProvider/jobProvider_sidebar.php'; ?>
    <div class="main-content">
        <div class="job-cards container flex-col">
            <h2>Reviews</h2>
            <hr style="width: 100%">
            <div class="search-container">
                <input 
                    type="text" 
                    class="search-bar" 
                    placeholder=" Find Employees"
                    aria-label="Search" 
                    style="height: 20px; width: 700px">
            </div>
            <div class="job-card container">
                <div class="job-card-left flex-row">
                    <div class="profile flex-row">
                        <!-- Updated image src for debugging -->
                        <img 
                            src="<?=ROOT?>/assets/images/profile.png" 
                            alt="Profile Picture" 
                            class="profile-pic" 
                            onerror="this.src='<?=ROOT?>/assets/images/default-profile.png';">
                        <div class="review-details">
                            <p class="name">Noah Wick</p>
                            <p class="date-time">2024/09/4 at 12.45 a.m.</p>
                            <div class="rating">
                                <span>
                                    <i class="fa fa-star star-active mx-1"></i>
                                    <i class="fa fa-star star-active mx-1"></i>
                                    <i class="fa fa-star star-active mx-1"></i>
                                    <i class="fa fa-star star-active mx-1"></i>
                                    <i class="fa fa-star star-active mx-1"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="review-text">
                        <p class="text">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio maxime soluta inventore quis. Vel quos fuga debitis dicta laborum fugit libero eveniet! Error, placeat consectetur incidunt maiores mollitia cumque totam perspiciatis! Corrupti atque, illum id vero nulla eius ut cupiditate? Distinctio, animi. Placeat, illo eius.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
