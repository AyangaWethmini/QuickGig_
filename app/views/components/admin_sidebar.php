<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?=ROOT?>/assets/css/admin/admin_sidebar.css">
    <div class="admin-sidebar">
        <div class="signup_logo">
            <img src="<?php echo ROOT; ?>/public/assets/images/QuickGigLogo.png" alt="Description of image">
        </div>
        <div class="admin-anchor-list">
            
            <a href="<?php echo ROOT; ?>/admin/adminadvertisements"><i class="fa-solid fa-building" style="padding-right: 3px;"></i>Advertisements</a>

            <a href="<?php echo ROOT; ?>/admin/adminannouncement" class="<?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/adminannouncement') !== false || strpos($_SERVER['REQUEST_URI'], '/admin/admincreateannouncement') !== false) ? 'active' : ''; ?>"><i class="fa-solid fa-building" style="padding-right: 3px;"></i>Announcements</a>

            <a href="<?php echo ROOT; ?>/admin/admincomplaints" class="<?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/admincomplaints') !== false) ? 'active' : ''; ?>"><i class="fa-solid fa-users" style="padding-right: 3px;"></i>Complaints</a>
            
            <br><hr><br>
            
            <a href="<?php echo ROOT; ?>/admin/adminsettings" class="<?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/adminsettings') !== false || strpos($_SERVER['REQUEST_URI'], '/admin/admindeleteaccount') !== false || strpos($_SERVER['REQUEST_URI'], '/admin/adminlogindetails') !== false) ? 'active' : ''; ?>"><i class="fa-solid fa-user" style="padding-right: 3px;"></i>Settings</a>       

        </div>

    </div>
    
<?php require APPROOT . '/views/inc/footer.php'; ?>
