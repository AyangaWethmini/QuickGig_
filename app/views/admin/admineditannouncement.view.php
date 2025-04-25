<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php';
protectRoute([0]); ?>
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
                <h1 class="page-title">Update Announcement</h1>
            </div>
            <form action="<?php echo ROOT; ?>/admin/updateAnnouncement/<?php echo $data['announcementID']; ?>" method="post" class="announcement-form">
                <div class="form-container">
                    <!-- Hidden Field for Announcement ID -->
                    <input
                        type="hidden"
                        name="announcementID"
                        value="<?php echo $data['announcementID']; ?>">

                    <!-- Announcement Date -->
                    <div class="form-group">
                        <label for="announcementDate" class="form-label">Announcement Date</label>
                        <input
                            type="date"
                            class="form-input"
                            name="announcementDate"
                            id="announcementDate"
                            value="<?php echo $data['announcementDate'] ?? ''; ?>">
                        <span class="form-invalid"><?php echo $data['announcementDate_error'] ?? ''; ?></span>
                    </div>

                    <!-- Announcement Time -->
                    <div class="form-group">
                        <label for="announcementTime" class="form-label">Announcement Time</label>
                        <input
                            type="time"
                            class="form-input"
                            name="announcementTime"
                            id="announcementTime"
                            value="<?php echo $data['announcementTime'] ?? ''; ?>">
                        <span class="form-invalid"><?php echo $data['announcementTime_error'] ?? ''; ?></span>
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="body" class="form-label">Description</label>
                        <textarea
                            class="form-textarea"
                            name="body"
                            id="body"
                            placeholder="Enter Announcement"
                            rows="10"><?php echo $data['content'] ?? ''; ?></textarea>
                        <span class="form-invalid"><?php echo $data['content_error'] ?? ''; ?></span>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="button-container">
                    <button class="post-button">Update Announcement</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Layout Styles */
    .admin-container {
        padding: 20px;
    }

    .post-container {
        width: 90%;
    }

    .announcement-form {
        width: 100%;
        display: flex;
        flex-direction: column;
    }

    /* Heading Styles */
    .page-title {
        font-size: 3.2rem;
        margin-bottom: 20px;
        font-weight: bold;
    }

    /* Form Container */
    .form-container {
        width: 100%;
        margin: 20px 0;
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        transition: transform 0.3s ease;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        border-left: 5px solid #4640DE;
        box-sizing: border-box;
    }

    .form-container:hover {
        transform: translateY(-5px);
    }

    /* Form Elements */
    .form-group {
        margin-bottom: 25px;
    }

    .form-label {
        display: block;
        font-size: 1.2rem;
        color: #25324B;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .form-input,
    .form-textarea {
        width: 100%;
        padding: 12px;
        font-size: 1.5rem;
        border: 1px solid #ccc;
        border-radius: 8px;
        box-sizing: border-box;
        transition: all 0.3s ease;
    }

    .form-textarea {
        min-height: 150px;
        padding: 15px;
    }

    .form-input:focus,
    .form-textarea:focus {
        border-color: #4640DE;
        outline: none;
        box-shadow: 0 0 0 3px rgba(70, 64, 222, 0.2);
    }

    .form-invalid {
        color: #e74c3c;
        font-size: 0.9rem;
        margin-top: 8px;
        display: block;
    }

    /* Button Styles */
    .button-container {
        width: 100%;
        padding: 0;
        margin-top: 30px;
        box-sizing: border-box;
    }

    .post-button {
        width: 100%;
        height: 50px;
        font-size: 1.3rem;
        font-weight: bold;
        border-radius: 8px;
        background-color: #4640DE;
        color: white;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .post-button:hover {
        background-color: #372ebf;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(70, 64, 222, 0.3);
    }
</style>

<?php require APPROOT . '/views/inc/footer.php'; ?>