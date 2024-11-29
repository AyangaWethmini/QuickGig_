<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?php echo ROOT; ?>/assets/css/admin/admin_editannouncement.css">
<?php include APPROOT . '/views/components/navbar.php'; ?>

<div class="admin-layout">
    <?php require APPROOT . '/views/components/admin_sidebar.php'; ?>
    <div class="admin-container">
        <div class="post-container">
            <div class="announcement-header">
                <a href="<?php echo ROOT; ?>/admin/adminannouncement" class="back-link">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h1>Update Announcement</h1>
            </div>
            <form action="<?php echo ROOT; ?>/admin/updateAnnouncement/<?php echo $data['announcementID']; ?>" method="post">
                <h2>Announcement Details</h2>
                
                <div class="form-container">
                    <!-- Hidden Field for Announcement ID -->
                    <input 
                        type="hidden" 
                        name="announcementID" 
                        value="<?php echo $data['announcementID']; ?>"
                    >

                    <!-- Announcement Date -->
                    <div class="form-group">
                        <label for="announcementDate">Announcement Date</label>
                        <input 
                            type="date" 
                            class="admin-input" 
                            name="announcementDate" 
                            id="announcementDate" 
                            value="<?php echo $data['announcementDate'] ?? ''; ?>"
                        >
                        <span class="form-invalid"><?php echo $data['announcementDate_error'] ?? ''; ?></span>
                    </div>

                    <!-- Announcement Time -->
                    <div class="form-group">
                        <label for="announcementTime">Announcement Time</label>
                        <input 
                            type="time" 
                            class="admin-input" 
                            name="announcementTime" 
                            id="announcementTime" 
                            value="<?php echo $data['announcementTime'] ?? ''; ?>"
                        >
                        <span class="form-invalid"><?php echo $data['announcementTime_error'] ?? ''; ?></span>
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="body">Description</label>
                        <textarea 
                            class="admin-textarea" 
                            name="body" 
                            id="body" 
                            placeholder="Enter Announcement" 
                            rows="10"
                        ><?php echo $data['content'] ?? ''; ?></textarea>
                        <span class="form-invalid"><?php echo $data['content_error'] ?? ''; ?></span>
                    </div>

                </div>

                <!-- Submit Button -->
                <button class="btn btn-accent srch-btn" style="margin-left:22.5%; width:945px;">Update</button>   
            </form>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
