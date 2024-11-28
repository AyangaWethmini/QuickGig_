<link rel="stylesheet" href="<?=ROOT?>/assets/css/Components/jobProvider_sidebar.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<body>
    
    <div class="sidebar-container">

        <div class="sidebar-items-container">
            <!-- <img src="<?=ROOT?>/assets/images/logo1.png" alt="" style="height: 40px; width:
            130px; margin: 30px auto;"> -->

            <a href="<?php echo ROOT;?>/manager/profile" class="sidebar-item">
                <span class="sidebar-icon"><i class="fa-solid fa-user"></i></span>
                <span class="sidebar-label">Profile</span>
            </a>
            
            <a href="<?php echo ROOT;?>/manager/dashboard" class="sidebar-item">
            <span class="sidebar-icon"><i class="fa-solid fa-chart-area"></i></span>
                <span class="sidebar-label">Dashboard</span>
            </a>
            <a href="<?php echo ROOT;?>/manager/advertisements" class="sidebar-item">
                <span class="sidebar-icon"><i class="fa-solid fa-rectangle-ad"></i></span>
                <span class="sidebar-label">Advertisements</span>
            </a>
            <a href="<?php echo ROOT;?>/manager/plans" class="sidebar-item">
                <span class="sidebar-icon"><i class="fa-solid fa-certificate"></i></span>
                <span class="sidebar-label">Subscriptions</span>
            </a>

            <a href="<?php echo ROOT;?>/manager/announcements" class="sidebar-item">
                <span class="sidebar-icon"><i class="fa-solid fa-bullhorn"></i></span>
                <span class="sidebar-label">Announcements</span>
            </a>

            
            <hr>
            <br><br><br>
            <a href="<?php echo ROOT;?>/admin/settings" class="sidebar-item">
                <span class="sidebar-icon"><i class="fa-sharp fa-solid fa-gear"></i></span>
                <span class="sidebar-label">Settings</span>
            </a>
            <a href="<?php echo ROOT;?>/manager/helpCenter" class="sidebar-item">
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