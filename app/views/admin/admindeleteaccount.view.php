<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([0]);?>
<?php include APPROOT . '/views/components/navbar.php'; ?>

<div class="admin-layout">
    <?php require APPROOT . '/views/components/admin_sidebar.php'; ?>
    <div class="admin-container">
        <div class="admin-announcement-header">
            <h1>Settings</h1>
        </div>
        <br><hr><br>
        <div class="admin-functions">
            <div>
                <a href="<?php echo ROOT; ?>/admin/adminsettings" class="admin-link <?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/adminsettings') !== false) ? 'active' : ''; ?>">My Profile</a>
            </div>
            <div>
                <a href="<?php echo ROOT; ?>/admin/adminlogindetails" class="admin-link <?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/adminlogindetails') !== false || strpos($_SERVER['REQUEST_URI'], '/admin/admindeleteaccount') !== false) ? 'active' : ''; ?>">Login Details</a>
            </div>
        </div>
        <br><hr>
        <div class="update-container">
            <div class="update-container-one">
                <h2>Enter Password</h2>
            </div>
            <div class="update-container-two">
                <input type="text" name="delete-password" id="delete-password" placeholder="Enter password" value="">
                <button class="btn btn-accent srch-btn">Delete Account</button>
            </div>
        </div>
        <br><hr>
        <div class="update-delete-account">
            <a href="<?php echo ROOT; ?>/admin/adminlogindetails"><i class="fa-solid fa-arrow-left" style="padding-right: 3px;"></i>Go back</a>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>