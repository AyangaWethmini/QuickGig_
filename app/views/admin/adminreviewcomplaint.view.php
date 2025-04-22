<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php';
protectRoute([0]); ?>
<div class="admin-layout">
    <?php require APPROOT . '/views/components/admin_sidebar.php'; ?>
    <div class="admin-container">
        <div class="post-container">
            <div class="announcement-header">
                <a href="<?php echo ROOT; ?>/admin/admincomplaints" class="back-link">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            </div>

        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>