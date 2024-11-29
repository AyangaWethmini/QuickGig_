<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?=ROOT?>/assets/css/admin/admin_announcement.css">
<?php include APPROOT . '/views/components/navbar.php'; ?>


<div class="admin-layout">
    <?php require APPROOT . '/views/components/admin_sidebar.php'; ?>
    <div class="admin-container">
        <div class="admin-announcement-header">
            <h1>Current Advertisements</h1>
            <!-- <a href="<?php echo ROOT; ?>/admin/admincreateannouncement">
                <input type="submit" value="+ Post Advertisements" class="form-btn">
            </a> -->
        </div>
        <br><hr><br>
        <div class="admin-announcement-searchbar">
            <input type="search" name="query" placeholder="Search Advertisements">
        </div>
        <div class="admin-announcement-filterheader">
            <h1>All Advertisements</h1>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
