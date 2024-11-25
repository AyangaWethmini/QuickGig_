<?php require APPROOT . '/views/inc/header.php';?>
<div class="admin-layout">
    <?php require APPROOT . '/views/components/admin_sidebar.php'; ?>
    <div class="admin-container">
        <div class="admin-announcement-header">
            <h1>Current Announcements</h1>
            <a href="<?php echo ROOT; ?>/admin/admincreateannouncement">
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
        <?php foreach($data['announcements'] as $announcement): ?>
            <div class="announcement-index-container">
                <div class="announcement-header">
                    <div class="announcement-created-date"><?php echo $announcement->announcementDate ?></div>
                    <div class="announcement-created-at"><?php echo $announcement->announcementTime ?></div>
                    <div class="post-control-btns">
                        <a href="<?php echo ROOT; ?>/admin/admineditannouncement/<?php echo $announcement->announcementID; ?>">
                            <button class="post-control-btn1">EDIT</button>
                        </a>
                        <a href="<?php echo ROOT; ?>/admin/deleteAnnouncement/<?php echo $announcement->announcementID; ?>" 
                           onclick="return confirm('Are you sure you want to delete this announcement?')">
                            <button class="post-control-btn1">DELETE</button>
                        </a>

                    </div>
                </div>
                <div class="announcement-body">
                    <div class="announcement-body"><?php echo $announcement->content ?></div>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
