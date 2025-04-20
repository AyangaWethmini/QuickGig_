<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php';
protectRoute([2]); ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?= ROOT ?>/assets/css/jobProvider/individualProfile.css">
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/jobProvider/viewEmployeeProfile.css">
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/jobProvider/reviews.css">
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/jobProvider/jobListing.css">


<body>
    <div class="wrapper flex-row">
        <?php require APPROOT . '/views/jobProvider/jobProvider_sidebar.php'; ?>
        <div class="profile-container">
            <div class="profile-header">
                <div class="profile-info">
                    <div class="intro">
                    <img src="<?= !empty($data['pp']) ? 'data:image/jpeg;base64,' . base64_encode($data['pp']) : ROOT . '/assets/images/default.jpg' ?>" alt="Profile Picture" class="profile-pic">
                    
                        <div class="profile-intro">

                            <h2><?= htmlspecialchars(($data['fname'] ?? '') . ' ' . ($data['lname'] ?? '')) ?></h2><br>
                            <p>Bartender</p><br>
                            <p><?= htmlspecialchars(($data['city'] ?? '') . ',' . ($data['district'] ?? '')) ?></p>
                        </div>
                        <div class="profile-rating">★★★★★</div>
                        
                    </div>
                    <div  class="sendmsg">
                        <a href="<?= ROOT ?>/message/startConversation/<?= $data['accountID'] ?>">
                        <button class="sendmsg-btn">Send Message</button>
                        </a>
                    </div>
                    

                </div>
                
                <div class="profile-contacts">
                    <div class="additional-details">
                        <h2>Additional Details</h2> <br>
                        <p class="title-items">Email</p>
                        <p class="detail-items"><?= htmlspecialchars(($data['email'] ?? 'No email given')) ?></p><br>
                        <p class="title-items">Phone</p>
                        <p class="detail-items"><?= htmlspecialchars(($data['phone'] ?? 'No number given')) ?></p><br>
                    </div>
                    <div class="social-links">
                        <h2>Social Links</h2> <br>
                        <p class="title-items">LinkedIn</p>
                        <p class="detail-items"><?= htmlspecialchars(($data['linkedin'] ?? 'No link given')) ?></p><br>
                        <p class="title-items">facebook</p>
                        <p class="detail-items"><?= htmlspecialchars(($data['facebook'] ?? 'No link given')) ?></p><br>
                    </div>
                </div>
            </div>
            <div class="profile-about">
                <h3>About Me</h3>
                <p><?= htmlspecialchars(($data['bio'] ?? '')) ?></p>
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
                            <img src="<?= ROOT ?>/assets/images/person3.jpg" alt="Profile Picture" class="profile-pic-reviewed-employee">
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
                            <img src="<?= ROOT ?>/assets/images/person3.jpg" alt="Profile Picture" class="profile-pic-reviewed-employee">
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
                            <img src="<?= ROOT ?>/assets/images/person3.jpg" alt="Profile Picture" class="profile-pic-reviewed-employee">
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