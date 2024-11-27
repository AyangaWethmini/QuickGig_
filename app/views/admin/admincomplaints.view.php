<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo ROOT; ?>/assets/css/admin/admin_announcement.css">
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

            <div class="complaint container">
            <div class="complaint-content flex-col">
                <div class="complaint-details flex-row">
                    <div class="complaint-text flex-col">
                        <div class="the-complaint">There was sensitive content displayed by the user</div>   
                        <div class="text-grey">
                            <!-- <?php 
                            $formattedTime = date('h:i A', strtotime($announcement->announcementTime)); 
                            echo $announcement->announcementDate . ' | ' . $formattedTime; 
                            ?> -->
                        </div>
                    </div>
                </div>
                <div class="complaint-actions flex-row">
                    <a>
                        <select class="dropdown complaint-status">
                            <option value="pending">Pending</option>
                            <option value="reviewed">Under Reviewed</option>
                            <option value="reviewed">Reviewed</option>
                        </select>
                    </a>   
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
