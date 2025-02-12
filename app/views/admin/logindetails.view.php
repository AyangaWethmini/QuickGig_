<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([0]);?>
<div class="admin-layout">
    <?php require APPROOT . '/views/inc/components/admin_sidebar.php'; ?>
    <div class="admin-container">
        <div class="admin-announcement-header">
            <h1>Settings</h1>
        </div>
        <br><hr><br>
        <div class="admin-functions">
            <div>
                <a href="<?php echo URLROOT; ?>/admin/adminsettings" class="admin-link <?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/adminsettings') !== false) ? 'active' : ''; ?>">My Profile</a>
            </div>
            <div>
                <a href="<?php echo URLROOT; ?>/admin/adminlogindetails" class="admin-link <?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/adminlogindetails') !== false) ? 'active' : ''; ?>">Login Details</a>
            </div>
        </div>
        <br><hr>
        <div class="update-container">
            <div class="update-container-one">
                <h2>Update Email</h2>
                <p>Update your email address to make sure it is safe</p>
            </div>
            <div class="update-container-two">
                <p><b>jakegyll@email.com</b><i class="fa-regular fa-circle-check" style="padding-left: 3px;"></i></p>
                <p>Your email address is verified</p>
                <h3>Update Email</h3>
                <input type="text" name="update-email" id="update-email" placeholder="Enter your new email" value="">
                <input type="submit" value="Update Email" class="form-btn">
            </div>
        </div>
        <br><hr>
        <div class="update-container">
            <div class="update-container-one">
                <h2>Update Password</h2>
                <p>Manage your password to make sure it is safe</p>
            </div>
            <div class="update-container-two">
                <h3><b>Old Password</b></h3>
                <input type="text" name="enter-old-password" id="enter-old-password" placeholder="Enter your old password" value="">
                <h3><b>New Password</b></h3>
                <input type="text" name="enter-new-password" id="enter-new-password" placeholder="Enter your new password" value="">
                <input type="submit" value="Update Password" class="form-btn">
            </div>
        </div>
        <br><hr>
        <div class="update-delete-account">
            <a href="<?php echo URLROOT; ?>/admin/admindeleteaccount">Delete Account<i class="fa-solid fa-circle-exclamation" style="padding-left: 3px;"></i></a>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
