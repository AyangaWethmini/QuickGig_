<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="admin-layout">
    <?php require APPROOT . '/views/components/admin_sidebar.php'; ?>
    <div class="admin-container">
        <div class="admin-announcement-header">
            <h1>Current Complaints</h1>
        </div>
        <br><hr><br>
        <div class="admin-announcement-searchbar">
            <input type="search" name="query" placeholder="Search Complaints">
        </div>
        <div class="admin-announcement-filterheader">
            <h1>All Complaints</h1>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
