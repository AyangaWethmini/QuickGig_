<?php require APPROOT . '/views/inc/header.php'; ?>
    <div class="admin-sidebar">
        <div class="signup_logo">
            <img src="<?php echo URLROOT; ?>/public/assets/img/logo.png" alt="Description of image">
        </div>
        <div class="admin-anchor-list">
            <a><i class="fa-solid fa-house" style="padding-right: 3px;"></i>Dashboard</a>            
            
            <!-- <a><i class="fa-solid fa-building" style="padding-right: 3px;" class="<?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/adminannouncement') !== false) ? 'active' : ''; ?>"></i>Advertisements</a> -->

            <a href="<?php echo URLROOT; ?>/admin/adminannouncement" class="<?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/adminannouncement') !== false || strpos($_SERVER['REQUEST_URI'], '/admin/admincreateannouncement') !== false) ? 'active' : ''; ?>"><i class="fa-solid fa-building" style="padding-right: 3px;"></i>Announcements</a>

            <a href="<?php echo URLROOT; ?>/admin/admincomplaints" class="<?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/admincomplaints') !== false) ? 'active' : ''; ?>"><i class="fa-solid fa-users" style="padding-right: 3px;"></i>Complaints</a>
            <!-- <a>Job Listing</a> -->
            
            <a href="<?php echo URLROOT; ?>/admin/adminmanageusers" class="<?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/adminmanageusers') !== false) ? 'active' : ''; ?>"><i class="fa-solid fa-user" style="padding-right: 3px;"></i>Manage Users</a>
            <br><hr><br>
            
            <a href="<?php echo URLROOT; ?>/admin/adminsettings" class="<?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/adminsettings') !== false || strpos($_SERVER['REQUEST_URI'], '/admin/admindeleteaccount') !== false || strpos($_SERVER['REQUEST_URI'], '/admin/adminlogindetails') !== false) ? 'active' : ''; ?>"><i class="fa-solid fa-user" style="padding-right: 3px;"></i>Settings</a>       

        </div>

    </div>
    
<?php require APPROOT . '/views/inc/footer.php'; ?>