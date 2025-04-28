<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([3]);?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?=ROOT?>/assets/css/jobProvider/jobListing.css">

<body>
<script src="<?=ROOT?>/assets/js/jobProvider/jobListing.js"></script>
<div class="wrapper flex-row">
<?php require APPROOT . '/views/jobProvider/organization_sidebar.php'; ?>
    <div class="inclusion-container">
        <div class="opener">
            <p class="title-name">My Jobs</p>
            <button class="post-job-btn">+ Post a job</button>
        </div> <br> <hr>

        <div class="expressionNselect-dates">
            <p class="expression">Here We Go!!!</p>
            <button class="select-dates-btn">Nov 18 - Nov 24</button>
        </div>

        <div class="category-container">
            <div class="category">My Jobs (1)</div>
            <div class="category">Received (3)</div>
            <div class="category">Send (0)</div>
            <div class="category">To be completed (0)</div>
            <div class="category">Ongoing (0)</div>
            <div class="category">Completed (1)</div>
        </div> <hr> <br>

        <div class="list-header">
            <p class="list-header-title">Job History</p>
            <input type="text" class="search-input" placeholder="Search..."> 
            <button class="filter-btn">Filter</button>
        </div> <br>

        <div class="employee-list">
            
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
</body>