<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?=ROOT?>/assets/css/jobProvider/individualProfile.css">
<link rel="stylesheet" href="<?=ROOT?>/assets/css/jobProvider/viewEmployeeProfile.css">
<link rel="stylesheet" href="<?=ROOT?>/assets/css/jobProvider/jobListing.css">

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
                <button class="btn edit-profile">Edit Profile</button>
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
        <div class="list-header">
            <p class="list-header-title">Job History</p>
            <input type="text" class="search-input" placeholder="Search..."> 
            <button class="filter-btn">Filter</button>
        </div> <br>

        <div class="employee-list-view-employee">
            
            <div class="employee-item">
                <span class="employee-id">1</span>
                <div class="employee-photo">
                    <img src="<?=ROOT?>/assets/images/person1.jpg" alt="Profile Picture">
                </div>
                <div class="employee-details">
                    <span class="employee-name">Nomad Nova</span>
                    <span class="job-title">Bartender</span>
                    <span class="date-applied">24 July 2024</span>
                    <div class="ratings">
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    </div>
                </div>
                <button class="more-options">⋮</button>
            </div>

            <div class="employee-item">
                <span class="employee-id">2</span>
                <div class="employee-photo">
                    <img src="<?=ROOT?>/assets/images/person2.jpg" alt="Profile Picture">
                </div>
                <div class="employee-details">
                    <span class="employee-name">Clara Zue</span>
                    <span class="job-title">Waiter</span>
                    <span class="date-applied">23 July 2024</span>
                    <div class="ratings">
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    </div>
                </div>
                <button class="more-options">⋮</button>
            </div>

            <div class="employee-item">
                <span class="employee-id">3</span>
                <div class="employee-photo">
                    <img src="<?=ROOT?>/assets/images/person3.jpg" alt="Profile Picture">
                </div>
                <div class="employee-details">
                    <span class="employee-name">Kane Smith</span>
                    <span class="job-title">Plumber</span>
                    <span class="date-applied">20 July 2024</span>
                    <div class="ratings">
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    </div>
                </div>
                <button class="more-options">⋮</button>
            </div>

        </div>


    </div>
</div>