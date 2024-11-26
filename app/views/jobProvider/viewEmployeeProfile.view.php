<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?=ROOT?>/assets/css/jobProvider/individualProfile.css">
<link rel="stylesheet" href="<?=ROOT?>/assets/css/jobProvider/viewEmployeeProfile.css">
<link rel="stylesheet" href="<?=ROOT?>/assets/css/jobProvider/reviews.css">

<body>
<div class="wrapper flex-row">
    <?php require APPROOT . '/views/jobProvider/jobProvider_sidebar.php'; ?>
    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-info">
                <img src="<?=ROOT?>/assets/images/person3.jpg" alt="Profile Picture" class="profile-pic">
                <div class="intro">
                    <div class="profile-intro">
                        <h2>Smith Greenwood</h2><br>
                        <p>Bartender</p><br>
                        <p>Manchester, UK</p>
                    </div>
                    <div class="profile-rating">★★★★★</div>
                </div>
                
            </div>
            <div class="profile-contacts">
                <div class="additional-details">
                    <h2>Additional Details</h2> <br>
                    <p class="title-items">Email</p> 
                    <p class="detail-items">smithGreen@gmail.com</p><br>
                    <p class="title-items">Phone</p>
                    <p class="detail-items">+44 1245 572 135</p><br>
                    <p class="title-items">Languages</p>
                    <p class="detail-items">English, French</p>
                </div>
                <div class="social-links">
                    <h2>Social Links</h2> <br>
                        <p class="title-items">Instagram</p>
                        <p class="detail-items">instagram.com/smithGreen</p><br>
                        <p class="title-items">Twitter</p>
                        <p class="detail-items">twitter.com/SmithGreenwood</p><br>                 
                </div>
            </div>    
        </div>
        <div class="profile-about">
            <h3>About Me</h3>
            <p>With years of experience in farming, I'm seeking reliable and motivated individuals to assist with daily farm tasks. Our farm, spanning over 150 acres, is a lush, green oasis teeming with life. We cultivate a variety of crops, including wheat, cabbage, carrots. Our farm is home to cows, chickens, ducks, goats and pigs, which contribute to a sustainable and harmonious ecosystem. We provide a comfortable and safe working environment for our workers, with access to clean water and basic amenities.</p>
        </div>
        <div class="interested-categories-container">
            <p class="interested-categories-title">Interested Categories</p>
            <div class="interested-categories">
                <div class="interested-category">Waiter</div>
                <div class="interested-category">Bartender</div>
                <div class="interested-category">Kitchen Helper</div>
                <div class="interested-category">Cleaning</div>
                <div class="interested-category">Cashier</div>
                <div class="interested-category">Plumber</div>
            </div>
        </div> <br> <br>

        <div class="reviews-section">
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
        </div>


    </div>
</div>