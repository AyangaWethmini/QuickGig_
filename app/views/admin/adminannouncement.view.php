
<?php require APPROOT . '/views/inc/header.php'; 
require_once APPROOT . '/views/inc/protectedRoute.php';
    protectRoute([0]);
?>
<link rel="stylesheet" href="<?=ROOT?>/assets/css/admin/admin_announcement.css">
<?php include APPROOT . '/views/components/navbar.php'; ?>

<div class="admin-layout">
    <?php require APPROOT . '/views/components/admin_sidebar.php'; ?>
    <div class="admin-container">
        <div class="admin-announcement-header">
            <h1>Current Announcements</h1>

            <a href="<?php echo ROOT; ?>/admin/createannouncement">
                <button class="btn btn-accent srch-btn">+ Post Announcement</button>
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
            <?php if (!empty($data['announcements'])): ?>
                <?php foreach ($data['announcements'] as $announcement): ?>
                    <div class="complaint container">
                        <div class="complaint-content flex-col">
                            <div class="complaint-details flex-row">
                                <div class="complaint-text flex-col">
                                    <div class="the-complaint"><?php echo $announcement->content; ?></div>
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
                                    <button class="btn btn-update">Update</button>
                                </a>
                                <button class="btn btn-delete" onclick="confirmDelete(<?php echo $announcement->announcementID ?>)">Delete</button>                       
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>

            <?php endif; ?>
        </div>
    </div>
</div>
<div id="delete-confirmation" class="modal" style="display: none;">
    <div class="modal-content">
        <p>Are you sure you want to delete this announcement?</p>
        <button id="confirm-yes" class="popup-btn-delete-complaint">Yes</button>
        <button id="confirm-no" class="popup-btn-delete-complaint">No</button>
    </div>
</div>

<form id="delete-form" method="POST" style="display: none;"></form>

<script>
function confirmDelete(id) {
    var modal = document.getElementById('delete-confirmation');
    modal.style.display = 'flex';

    document.getElementById('confirm-yes').onclick = function() {
        var form = document.getElementById('delete-form');
        form.action = '<?=ROOT?>/admin/deleteAnnouncement/' + id;
        modal.style.display = 'none';

        form.submit();
    };

    document.getElementById('confirm-no').onclick = function() {
        modal.style.display = 'none';
    };
}
</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>
