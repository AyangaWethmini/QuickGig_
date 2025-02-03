<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/admin/admin_announcement.css">
<?php include APPROOT . '/views/components/navbar.php'; ?>
<div class="admin-layout">
    <?php require APPROOT . '/views/components/admin_sidebar.php'; ?>
    <div class="admin-container">
        <div class="admin-announcement-header">
            <h1>Current Advertisements</h1>

        </div>
        <br>
        <hr><br>
        <div class="admin-announcement-searchbar">
            <input type="search" name="query" placeholder="Search Advertisements">
        </div>
        <div class="admin-announcement-filterheader">
            <h1>All Advertisements</h1>
        </div>
        <div class="complaints-container container">
            <?php foreach ($data['ads'] as $ad): ?>
                <div class="complaint container">
                    <div class="complaint-details flex-col">
                        <div class="complaint-details flex-row admin-ad-details">
                            <div class="admin-ad">
                                <strong>Advertisement ID:</strong> <?php echo $ad->advertisementID; ?><br>
                                <strong>Advertisement Title:</strong> <?php echo $ad->adTitle; ?><br>
                                <strong>Advertisement Date:</strong> <?php echo $ad->adDate; ?><br>
                                <strong>Advertisement Description:</strong> <?php echo $ad->adDescription; ?><br>
                            </div>
                            <div class="image">
                                <?php if ($ad->img): ?>
                                    <?php
                                    // Get the mime type from the first few bytes of the BLOB
                                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                                    $mimeType = $finfo->buffer($ad->img);
                                    ?>
                                    <img src="data:<?= $mimeType ?>;base64,<?= base64_encode($ad->img) ?>" alt="Advertisement image">
                                <?php else: ?>
                                    <img src="<?= ROOT ?>/assets/images/placeholder.jpg" alt="No image available">
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>