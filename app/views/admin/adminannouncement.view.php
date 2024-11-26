<?php require APPROOT . '/views/inc/header.php';?>

<link rel="stylesheet" href="<?php echo ROOT; ?>/assets/css/admin/admin_announcement.css">
<div class="admin-layout">
    <?php require APPROOT . '/views/components/admin_sidebar.php'; ?>
    <div class="admin-container">
        <div class="admin-announcement-header">
            <h1>Current Announcements</h1>
            <a href="<?php echo ROOT; ?>/admin/admincreateannouncement">
                <button class="btn btn-accent srch-btn">+ Post Announcement"</button>
            </a>
        </div>
        <br><hr><br>
        <div class="admin-announcement-searchbar">
            <input type="search" name="query" placeholder="Search Announcements">
        </div>
        <div class="admin-announcement-filterheader">
            <h1>All Announcements</h1>
        </div>
        <div class="complaints-container container">
    <?php foreach($data['announcements'] as $announcement): ?>
        <div class="complaint container">
            <div class="complaint-content flex-col">
                <div class="complaint-details flex-row">
                    <div class="complaint-text flex-col">
                        <div class="the-complaint"><?php echo $announcement->content ?></div>   
                        <div class="text-grey">
                            <?php 
                            $formattedTime = date('h:i A', strtotime($announcement->announcementTime)); 
                            echo $announcement->announcementDate . ' | ' . $formattedTime; 
                            ?>
                        </div>
                    </div>
                </div>
                <div class="complaint-actions flex-row">
                    <a href="<?php echo ROOT; ?>/admin/admineditannouncement/<?php echo $announcement->announcementID; ?>">
                        <button class="btn btn-update" >Update</button>

                    </a>

                    <a href="<?php echo ROOT; ?>/admin/deleteAnnouncement/<?php echo $announcement->announcementID; ?>" 
                           onclick="return confirm('Are you sure you want to delete this announcement?')">
                        <button class="btn btn-delete" >Delete</button>
                    </a>    
                </div>
            </div>
        </div>
    <?php endforeach;?>
</div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
