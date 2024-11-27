
<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?=ROOT?>/assets/css/admin/admin_sidebar.css">
    <div class="admin-sidebar">
        <div class="signup_logo">
            <img src="<?php echo ROOT; ?>/public/assets/images/QuickGigLogo.png" alt="Description of image">
        </div>
        <div class="admin-anchor-list">
            
            <a href="<?php echo ROOT; ?>/admin/adminadvertisements"><i class="fa-solid fa-building" style="padding-right: 3px;"></i>Advertisements</a>
<body>
    
    <div class="sidebar-container">

        <div class="sidebar-items-container">
            <a href="<?php echo ROOT; ?>/admin/admindashboard" class="sidebar-item">
                <span class="sidebar-icon"><i class="fa-solid fa-chart-line"></i></span>
                <span class="sidebar-label">Dashboard</span>
            </a>

            <a href="<?php echo ROOT; ?>/admin/adminadvertisements" class="sidebar-item">
                <span class="sidebar-icon"><i class="fa-solid fa-rectangle-ad"></i></span>
                <span class="sidebar-label">Advertisements</span>
            </a>
            <a href="<?php echo ROOT; ?>/admin/adminannouncement" class="sidebar-item">
                <span class="sidebar-icon"><i class="fa-solid fa-bullhorn"></i></span>
                <span class="sidebar-label">Announcements</span>
            </a>
            <a href="<?php echo ROOT; ?>/admin/admincomplaints" class="sidebar-item">
                <span class="sidebar-icon"><i class="fa-solid fa-list-check"></i></span>
                <span class="sidebar-label">Complaints</span>
            </a>
            
            <br><hr><br>

            <a href="<?php echo ROOT; ?>/admin/adminsettings" class="sidebar-item">
                <span class="sidebar-icon"><i class="fa-solid fa-gear"></i></span>
                <span class="sidebar-label">Settings</span>
            </a>

            <a href="<?php echo ROOT; ?>/admin/adminsettings" class="sidebar-item">
                <span class="sidebar-icon"><i class="fa-solid fa-power-off"></i></span>
                <span class="sidebar-label">Logout</span>
            </a>
            
        </div>

    </div>

</body>