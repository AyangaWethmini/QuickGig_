<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?=ROOT?>/assets/css/JobProvider/reviews.css">

<div class="wrapper flex-row">
    <?php require APPROOT . '/views/seeker/seeker_sidebar.php'; ?>
    
    <div class="main-content-reviews">
        <div class="header">
            <div class="heading">Reviews</div>
        </div>
        <hr>
        <div class="search-container">
            <input type="text" 
                class="search-bar" 
                placeholder="Search reviews"
                aria-label="Search">
            <br><br>
            <div class="filter-container">
                <span>Sort by:</span>
                <select id="sortSelect" onchange="sortContent()">
                    <option value="recent">Latest</option>
                    <option value="views">Oldest</option>
                </select>
            </div>
        </div>
        <div class="reviews-container container">
            
            <div class="review-card container">
                <div class="review-card-left flex-row">
                    <div class="pfp">
                        <img src="<?=ROOT?>/assets/images/person3.jpg" alt="Profile Picture" class="profile-pic-reviewed-employee">
                    </div>
                
                    <div class="review-details">
                        <h2>Smith Greenwood</h2>
                        <p>Bartender</p>
                        <p>2024-11-27</p>
                        <p>03:30 PM</p>
                        <div style="display:flex;flex-direction:column; gap:20px">
                            <div class="rating">
                                <span>
                                    <i class="fa fa-star star-active mx-1"></i>
                                    <i class="fa fa-star star-active mx-1"></i>
                                    <i class="fa fa-star star-active mx-1"></i>
                                    <i class="fa fa-star star-active mx-1"></i>
                                    <i class="fa fa-star star-active mx-1"></i>
                                </span>
                            </div>
                        
                            <p class="review-text">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla distinctio id adipisci dicta facere tempora atque veniam! Rerum, minus expedita nobis magnam vel quibusdam natus!
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="review-card container">
                <div class="review-card-left flex-row">
                    <div class="pfp">
                        <img src="<?=ROOT?>/assets/images/person2.jpg" alt="Profile Picture" class="profile-pic-reviewed-employee">
                    </div>
                
                    <div class="review-details">
                        <h2>Sarah Ken</h2>
                        <p>Bartender</p>
                        <p>2024-11-24</p>
                        <p>03:30 PM</p>
                        <div style="display:flex;flex-direction:column; gap:20px">
                            <div class="rating">
                                <span>
                                    <i class="fa fa-star star-active mx-1"></i>
                                    <i class="fa fa-star star-active mx-1"></i>
                                    <i class="fa fa-star star-active mx-1"></i>
                                    <i class="fa fa-star star-active mx-1"></i>
                                    <i class="fa fa-star star-active mx-1"></i>
                                </span>
                            </div>
                        
                            <p class="review-text">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla distinctio id adipisci dicta facere tempora atque veniam! Rerum, minus expedita nobis magnam vel quibusdam natus!
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="review-card container">
                <div class="review-card-left flex-row">
                    <div class="pfp">
                        <img src="<?=ROOT?>/assets/images/person4.jpg" alt="Profile Picture" class="profile-pic-reviewed-employee">
                    </div>
                
                    <div class="review-details">
                        <h2>Samson Waltz</h2>
                        <p>Bartender</p>
                        <p>2024-11-19</p>
                        <p>05:37 PM</p>
                        <div style="display:flex;flex-direction:column; gap:20px">
                            <div class="rating">
                                <span>
                                    <i class="fa fa-star star-active mx-1"></i>
                                    <i class="fa fa-star star-active mx-1"></i>
                                    <i class="fa fa-star star-active mx-1"></i>
                                    <i class="fa fa-star star-active mx-1"></i>
                                    <i class="fa fa-star star-active mx-1"></i>
                                </span>
                            </div>
                        
                            <p class="review-text">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla distinctio id adipisci dicta facere tempora atque veniam! Rerum, minus expedita nobis magnam vel quibusdam natus!
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>