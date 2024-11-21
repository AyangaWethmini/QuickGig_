<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="admin-layout">
    <?php require APPROOT . '/views/inc/components/admin_sidebar.php'; ?>
    <div class="admin-container">
        <div class="admin-announcement-header">
            <h1>Current Announcements</h1>
            <a href="<?php echo URLROOT; ?>/admin/admincreateannouncement">
                <input type="submit" value="+ Post Announcement" class="form-btn">
            </a>
        </div>
        <br><hr><br>
        <div class="admin-announcement-searchbar">
            <input type="search" name="query" placeholder="Search Announcements">
        </div>
        <div class="admin-announcement-filterheader">
            <h1>All Announcements</h1>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>