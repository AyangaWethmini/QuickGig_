<?php require APPROOT . '/views/inc/header.php'; ?>
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
                
                <!-- Hidden Field for Announcement ID -->
                <input 
                    type="hidden" 
                    name="announcementID" 
                    value="<?php echo $data['announcementID']; ?>"
                >

                <!-- Announcement Date -->
                <label for="announcementDate">Announcement Date</label>
                <input 
                    type="date" 
                    class="admin-input" 
                    name="announcementDate" 
                    id="announcementDate" 
                    value="<?php echo $data['announcementDate'] ?? ''; ?>"
                >
                <span class="form-invalid"><?php echo $data['announcementDate_error'] ?? ''; ?></span>
                <br>
            
                <!-- Announcement Time -->
                <label for="announcementTime">Announcement Time</label>
                <input 
                    type="time" 
                    class="admin-input" 
                    name="announcementTime" 
                    id="announcementTime" 
                    value="<?php echo $data['announcementTime'] ?? ''; ?>"
                >
                <span class="form-invalid"><?php echo $data['announcementTime_error'] ?? ''; ?></span>
                <br>
            
                <!-- Description -->
                <label for="body">Description</label>
                <textarea 
                    class="admin-textarea" 
                    name="body" 
                    id="body" 
                    placeholder="Enter Announcement" 
                    rows="10" 
                    cols="183"
                ><?php echo $data['content'] ?? ''; ?></textarea>
                <span class="form-invalid"><?php echo $data['content_error'] ?? ''; ?></span>
                <br>
            
                <!-- Submit Button -->
                <input type="submit" value="Update" class="form-btn custom-btn">    
            </form>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
