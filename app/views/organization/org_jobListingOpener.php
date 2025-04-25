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
<div class="opener bar">
    <p class="title-name-opener">My Jobs</p>
    <a href="<?php echo ROOT; ?>/organization/org_postJob" class="post-job-btn">
        + Post a job
    </a>
</div> <br>