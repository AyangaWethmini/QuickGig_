<link rel="stylesheet" href="<?=ROOT?>/assets/css/Components/jobProvider_sidebar.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<body>
    
    <div class="sidebar-container">

        <div class="sidebar-items-container">
            <a href="<?php echo ROOT;?>/jobProvider/individualProfile" class="sidebar-item">
                <span class="sidebar-icon"><i class="fa-solid fa-user"></i></span>
                <span class="sidebar-label">My Profile</span>
            </a>
            <a href="<?php echo ROOT;?>/jobProvider/messages" class="sidebar-item">
                <span class="sidebar-icon"><i class="fa-solid fa-message"></i></span>
                <span class="sidebar-label">Messages</span>
            </a>
            <a href="<?php echo ROOT;?>/jobProvider/findEmployees" class="sidebar-item">
                <span class="sidebar-icon"><i class="fa-solid fa-address-card"></i></span>
                <span class="sidebar-label">Find Employees</span>
            </a>
            <a href="<?php echo ROOT;?>/jobProvider/jobListing_received" class="sidebar-item">
                <span class="sidebar-icon"><i class="fa-regular fa-clipboard"></i></span>
                <span class="sidebar-label">Job Listing</span>
            </a>
            <a href="<?php echo ROOT;?>/jobProvider/announcements" class="sidebar-item">
                <span class="sidebar-icon"><i class="fa-solid fa-bullhorn"></i></span>
                <span class="sidebar-label">Announcements</span>
            </a>
            <a href="<?php echo ROOT;?>/jobProvider/reviews" class="sidebar-item">
                <span class="sidebar-icon"><i class="fa-solid fa-pen-clip"></i></span>
                <span class="sidebar-label">Reviews</span>
            </a>
            <a href="<?php echo ROOT;?>/jobProvider/complaints" class="sidebar-item">
                <span class="sidebar-icon"><i class="fa-solid fa-list-check"></i></span>
                <span class="sidebar-label">complaints</span>
            </a>
             <br><br>
            <a href="<?php echo ROOT;?>/jobProvider/subscription" class="sidebar-item">
                <span class="sidebar-icon"><i class="fa-solid fa-certificate"></i></span>
                <span class="sidebar-label">Subscription</span>
            </a>
            <br><br>
            <div class="sidebar-item" data-link="settings.php">
                <span class="sidebar-icon"><i class="fa-solid fa-gear"></i></span>
                <span class="sidebar-label">Settings</span>
            </div>
            <a href="<?php echo ROOT;?>/jobProvider/helpCenter" class="sidebar-item">
                <span class="sidebar-icon"><i class="fa-solid fa-circle-question"></i></span>
                <span class="sidebar-label">Help Center</span>
            </a> 
            <div class="sidebar-item" data-link="login-logout.php">
                <span class="sidebar-icon"><i class="fa-solid fa-power-off"></i></span>
                <span class="sidebar-label">Log Out</span>
            </div> 
        </div>

    </div>

</body>