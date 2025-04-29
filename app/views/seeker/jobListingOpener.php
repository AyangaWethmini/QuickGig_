<link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/jobListingOpener.css">
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/errorPopUp.css">

<?php if (isset($_SESSION['postLimitExceeded']) && $_SESSION['postLimitExceeded']): ?>
    <div id="post-limit-popup" class="popup-message">
        <p>You have exceeded your post limit.</p>
    </div>
    <script>
        setTimeout(() => {
            document.getElementById('post-limit-popup').style.display = 'none';
        }, 3000);
    </script>
    <?php unset($_SESSION['postLimitExceeded']); ?>
<?php endif; ?>
<div>
    <div class="opener bar">
        <p class="title-name-opener">Job Listing</p>
        <a href="<?php echo ROOT; ?>/seeker/postJob" class="post-job-btn">
            + Available
        </a>
    </div> <br>
    <?php if ($_SESSION['plan_id'] == -1): ?>
        <div style="margin: 20px auto; display: flex; justify-content: center; flex-direction: column; align-items: center; background-color: #f5f5f5; padding: 10px; border-radius: 5px;">
            <p style="text-align: center; font-size: 12px; color: #555; margin-bottom: 10px;">Third-party Advertisement</p>
            <img src="<?= ROOT ?>/assets/images/placeholders/banner.png" alt="Advertisement" class="ad-image">
        </div>
    <?php endif; ?>
</div>