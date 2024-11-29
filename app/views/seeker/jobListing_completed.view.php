<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([2]);?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?=ROOT?>/assets/css/jobProvider/jobListing.css">


<body>
<div class="wrapper flex-row">
<?php require APPROOT . '/views/seeker/seeker_sidebar.php'; ?>
    <div class="inclusion-container">
        <?php require APPROOT . '/views/seeker/jobListingOpener.php'; ?>

        <div class="category-container">
        <?php require APPROOT . '/views/seeker/categoryLinksJobListing.php'; ?>
        </div> 
        <hr> 
        <br>

        <div class="list-header">
            <p class="list-header-title">Completed History</p>
            <input type="text" class="search-input" placeholder="Search..."> 
            <button class="filter-btn">Filter</button>
        </div> 
        <br>

        <div class="employee-list">
            <div class="employee-item">
                <div class="employee-photo">
                    <img src="<?=ROOT?>/assets/images/person3.jpg" alt="Profile Picture">
                </div>
                <div class="employee-details">
                    <span class="employee-name">Kane Smith</span>
                    <span class="job-title">Plumber</span>
                    <span class="date-available">2024-11-25</span>
                    <span class="time-available">03:00 PM - 05:00 PM</span>
                    <span class="jobId-applied">#6</span>
                    <div class="ratings">
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">☆</span>
                        <span class="star">☆</span>
                        <span class="star">☆</span>
                    </div>
                </div>
                <div class="dropdown">
                    <button class="dropdown-toggle"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                    <ul class="dropdown-menu">
                        <li><a href="#">Message</a></li>
                        <li><a href="<?php echo ROOT;?>/seeker/viewEmployeeProfile">View Profile</a></li>
                        <li><a href="<?php echo ROOT;?>/seeker/makeComplaint">Complain</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>