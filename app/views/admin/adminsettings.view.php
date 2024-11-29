<?php require APPROOT . '/views/inc/header.php'; ?>
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
                <a href="<?php echo ROOT; ?>/admin/adminlogindetails" class="admin-link <?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/adminlogindetails') !== false) ? 'active' : ''; ?>">Login Details</a>
            </div>
        </div>
        <br><hr>

        <!-- Content specific to My Profile page -->
        <div class="info-section">
            <h2>Full Name</h2>
            <div class="info-item">
                <p>John Emmanuel</p>
            </div>
        </div>
        <hr>

        <div class="info-section">
            <h2>Email</h2>
            <div class="info-item">
                <p>john@gmail.com</p>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
