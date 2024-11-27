<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?=ROOT?>/assets/css/jobProvider/individualProfile.css">
<link rel="stylesheet" href="<?=ROOT?>/assets/css/JobProvider/reviews.css">
<link rel="stylesheet" href="<?=ROOT?>/assets/css/jobProvider/jobListing.css">

<body>
<script src="<?=ROOT?>/assets/js/jobProvider/individualProfile.js"></script>
<div class="wrapper flex-row">
    <?php require APPROOT . '/views/jobProvider/jobProvider_sidebar.php'; ?>
    <div class="profile-container">
        <div class="profile-header">
            <div class="profile-info">
                <img src="<?=ROOT?>/assets/images/person1.jpg" alt="Profile Picture" class="profile-pic">
                <div class="profile-intro">
                    <h2>Jake Gyll</h2><br>
                    <p>Farm Owner</p><br>
                    <p>Manchester, UK</p>
                </div>
                <a href="<?php echo ROOT;?>/jobProvider/individualEditProfile" class="edit-profile-btn">
                Edit Profile
                </a>
            </div>
            <div class="profile-contacts">
                <div class="additional-details">
                    <h2>Additional Details</h2> <br>
                    <p class="title-items">Email</p> 
                    <p class="detail-items">jakegyll@gmail.com</p><br>
                    <p class="title-items">Phone</p>
                    <p class="detail-items">+44 1245 572 135</p><br>
                    <p class="title-items">Languages</p>
                    <p class="detail-items">English, French</p>
                </div>
                <div class="social-links">
                    <h2>Social Links</h2> <br>
                        <p class="title-items">Instagram</p>
                        <p class="detail-items">instagram.com/jakegyll</p><br>
                        <p class="title-items">Twitter</p>
                        <p class="detail-items">twitter.com/jakegyll</p><br>
                        <p class="title-items">Website</p>
                        <p class="detail-items">www.jakegyll.com</p>                  
                </div>
            </div>    
        </div>
        
        <div class="profile-about">
            <h3>About Me</h3>
            <p>With years of experience in farming, I'm seeking reliable and motivated individuals to assist with daily farm tasks. Our farm, spanning over 150 acres, is a lush, green oasis teeming with life. We cultivate a variety of crops, including wheat, cabbage, carrots. Our farm is home to cows, chickens, ducks, goats and pigs, which contribute to a sustainable and harmonious ecosystem. We provide a comfortable and safe working environment for our workers, with access to clean water and basic amenities.</p>
        </div>
        
        <span class="role-switch">
        <a href="<?php echo ROOT;?>/jobProvider/individualProfile" class="role-btn">Job Provider Role</a>
        <a href="<?php echo ROOT;?>/seeker/seekerProfile" class="role-btn">Job Seeker Role</a>
</span>

        <div class="rating-reviews">
            <h3>Rating and Reviews</h3>
            <div class="rating">
                <div class="container-fluid px-1 py-5 mx-auto flex">
                    <div class="row justify-content-center">
                        <div class="col-xl-7 col-lg-8 col-md-10 col-12 text-center mb-5">
                            <div class="card">
                                <div class="col-md-4 d-flex flex-row">
                                    <div class="col-md-4 d-flex flex-column">
                                        <div class="rating-box">
                                            <p class="pt-4">4.0</p>
                                        </div>
                                        <div> <span class="fa fa-star star-active mx-1"></span> <span class="fa fa-star star-active mx-1"></span> <span class="fa fa-star star-active mx-1"></span> <span class="fa fa-star star-active mx-1"></span> <span class="fa fa-star star-inactive mx-1"></span> </div>
                                    </div>
                                    <div class="bar-block">
                                        <div class="rating-bar0 justify-content-center">
                                            <table class="text-left mx-auto">
                                                <tr>
                                                    <td class="rating-label">Excellent</td>
                                                    <td class="rating-bar">
                                                        <div class="bar-container">
                                                            <div class="bar-5"></div>
                                                        </div>
                                                    </td>
                                                    <td class="text-right">123</td>
                                                </tr>
                                                <tr>
                                                    <td class="rating-label">Good</td>
                                                    <td class="rating-bar">
                                                        <div class="bar-container">
                                                            <div class="bar-4"></div>
                                                        </div>
                                                    </td>
                                                    <td class="text-right">23</td>
                                                </tr>
                                                <tr>
                                                    <td class="rating-label">Average</td>
                                                    <td class="rating-bar">
                                                        <div class="bar-container">
                                                            <div class="bar-3"></div>
                                                        </div>
                                                    </td>
                                                    <td class="text-right">10</td>
                                                </tr>
                                                <tr>
                                                    <td class="rating-label">Poor</td>
                                                    <td class="rating-bar">
                                                        <div class="bar-container">
                                                            <div class="bar-2"></div>
                                                        </div>
                                                    </td>
                                                    <td class="text-right">3</td>
                                                </tr>
                                                <tr>
                                                    <td class="rating-label">Terrible</td>
                                                    <td class="rating-bar">
                                                        <div class="bar-container">
                                                            <div class="bar-1"></div>
                                                        </div>
                                                    </td>
                                                    <td class="text-right">0</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="list-header">
            <p class="list-header-title">Job History</p>
            <input type="text" class="search-input" placeholder="Search..."> 
            <button class="filter-btn">Filter</button>
        </div> <br>

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
</body>
