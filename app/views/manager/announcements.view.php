<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; protectRoute([1]); ?>

<!-- Stylesheets -->
<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/manager.css">
<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/advertisements.css">
<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/announcements.css">

<?php include APPROOT . '/views/components/deleteConfirmation.php'; ?>


<?php include APPROOT . '/views/components/navbar.php'; ?>

<div class="wrapper flex-row">

    <?php require APPROOT . '/views/manager/manager_sidebar.php'; ?>
    <div class="main-content container">
        <div class="header flex-col">
            <h2>Announcements</h2>
            <hr>
        </div>

        <div class="flex-row"  class="ann-container">
            <!-- Create Form -->
            <div class="create-announcement-form container flex-col">
                <h3>Create Announcement</h3>
                <form action="<?=ROOT?>/manager/createAnnouncement" method="POST">
                    <div class="form-field">
                        <label for="content" class="text text-grey">Content</label><br>
                        <textarea name="content" id="content" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-accent">Create Announcement</button>
                </form>
            </div>

            <!-- All Announcements -->
            <div class="announcements container flex-col">
                <div class="filter flex-row justify-between">
                    <div>
                        <h3>All Announcements</h3>
                        <p class="text-grey">Showing <?= htmlspecialchars($annCount); ?> results</p>
                    </div>
                </div>

                <?php if (!empty($announcements) && (is_array($announcements) || is_object($announcements))): ?>
                    <?php foreach ($announcements as $announcement): ?>
                        <div class="announcement-card flex-col container">
                            <!-- <h3>Announcement ID: <?= htmlspecialchars($announcement->announcementID) ?></h3> -->
                            <p><?= htmlspecialchars($announcement->content) ?></p>
                            <div class="date-time"><?= htmlspecialchars($announcement->announcementDate) ?> at <?= htmlspecialchars($announcement->announcementTime) ?></div>
                            <button class="btn btn-del del-ann-btn" onclick = "showConfirmation('Are you sure you want to delete the advertisement?', 
                            () => submitForm('<?= ROOT ?>/manager/deleteAnnouncement/<?= htmlspecialchars($announcement->announcementID) ?>'))" >Delete</button>
                            
                            
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No announcements yet!</p>
                <?php endif; ?>
            </div>
        </div>

        
        <?php
            include_once APPROOT . '/views/components/alertBox.php';
            if (isset($_SESSION['error'])) {
                echo '<script>showAlert("' . htmlspecialchars($_SESSION['error']) . '", "error");</script>';
            }
            if (isset($_SESSION['success'])) {
                echo '<script>showAlert("' . htmlspecialchars($_SESSION['success']) . '", "success");</script>';
            }
            unset($_SESSION['error']);
            unset($_SESSION['success']);
        ?>
    </div>
</div>







