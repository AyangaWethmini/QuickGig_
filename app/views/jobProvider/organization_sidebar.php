<link rel="stylesheet" href="<?=ROOT?>/assets/css/Components/jobProvider_sidebar.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<body>
<script src="<?=ROOT?>/assets/js/sidebar.js"></script>      
    <div class="sidebar-container">

        <div class="sidebar-items-container">
            <a href="<?php echo ROOT;?>/organization/organizationProfile" class="sidebar-item">
                <span class="sidebar-icon"><i class="fa-solid fa-user"></i></span>
                <span class="sidebar-label">My Profile</span>
            </a>
            <a href="<?php echo ROOT;?>/message/chat" class="sidebar-item">
                <span class="sidebar-icon"><i class="fa-solid fa-message"></i></span>
                <span class="sidebar-label">Messages</span>
            </a>
            <a href="<?php echo ROOT;?>/organization/org_findEmployees" class="sidebar-item">
                <span class="sidebar-icon"><i class="fa-solid fa-address-card"></i></span>
                <span class="sidebar-label">Find Employees</span>
            </a>
            <a href="<?php echo ROOT;?>/organization/org_jobListing_received" class="sidebar-item">
                <span class="sidebar-icon"><i class="fa-regular fa-clipboard"></i></span>
                <span class="sidebar-label">Job Listing</span>
            </a>
            <a href="<?php echo ROOT;?>/organization/org_announcements" class="sidebar-item">
                <span class="sidebar-icon"><i class="fa-solid fa-bullhorn"></i></span>
                <span class="sidebar-label">Announcements</span>
            </a>
            <a href="<?php echo ROOT;?>/organization/org_reviews" class="sidebar-item">
                <span class="sidebar-icon"><i class="fa-solid fa-pen-clip"></i></span>
                <span class="sidebar-label">Reviews</span>
            </a>
            <a href="<?php echo ROOT;?>/organization/complaints" class="sidebar-item">
                <span class="sidebar-icon"><i class="fa-solid fa-list-check"></i></span>
                <span class="sidebar-label">complaints</span>
            </a>

            <a href="<?php echo ROOT;?>/organization/userReport" class="sidebar-item">
                <span class="sidebar-icon"><i class="fa-regular fa-chart-bar"></i></span>
                <span class="sidebar-label">Report</span>
            </a>

             <br><br>
             <a href="<?php echo ROOT;?>/organization/org_subscription" class="sidebar-item">
                <span class="sidebar-icon"><i class="fa-solid fa-certificate"></i></span>
                <span class="sidebar-label">Subscription</span>
            </a>
            <br><br>
            <a href="<?php echo ROOT;?>/organization/settings" class="sidebar-item">
                <span class="sidebar-icon"><i class="fa-solid fa-gear"></i></span>
                <span class="sidebar-label">Settings</span>
            </a>
            <a href="<?php echo ROOT;?>/organization/org_helpCenter" class="sidebar-item">
                <span class="sidebar-icon"><i class="fa-solid fa-circle-question"></i></span>
                <span class="sidebar-label">Help Center</span>
            </a> 
        </div>

    </div>

</body>