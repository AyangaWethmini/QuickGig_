<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="admin-layout">
    <?php require APPROOT . '/views/inc/components/admin_sidebar.php'; ?>
    <div class="admin-container">
        <div class="post-container">
            <div class="announcement-header">
                <a href="<?php echo URLROOT; ?>/admin/adminannouncement" class="back-link">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h1>Create Announcement</h1>
            </div>
            <form action="" method="post">
                <h2>Title</h2>
                <input type="text" name="title" id="title" placeholder="Title" value="">
                <span class="form-invalid"></span>
                <br>
                <h2> Description</h2>
                <textarea class="admin-textarea" name="body" id="body" placeholder="Enter Job Description" rows="10" cols="183" value=""></textarea>
                <span class="form-invalid"></span>
                <br>

            </form>  

            <div class="recipients-container">
                <h2>Recipients</h2>
                <label class="custom-checkbox">
                    <input type="checkbox" name="recipients[]" value="option1"> Admin
                </label>
                <label class="custom-checkbox">
                    <input type="checkbox" name="recipients[]" value="option2"> Job Seeker
                </label>
                <label class="custom-checkbox">
                    <input type="checkbox" name="recipients[]" value="option3"> Job Provider
                </label>
            </div>

            <input type="submit" value="Post" class="form-btn custom-btn">    
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
