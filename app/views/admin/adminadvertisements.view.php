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
                            <div class="admin-ad" style="flex: 1; padding: 20px; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                <strong style="display: inline-block; width: 180px; color: #2c3e50; font-weight: 600; margin-bottom: 10px;">Advertisement ID:</strong>
                                <span style="color: #34495e;"><?php echo $ad->advertisementID; ?></span><br>

                                <strong style="display: inline-block; width: 180px; color: #2c3e50; font-weight: 600; margin-bottom: 10px;">Advertisement Title:</strong>
                                <span style="color: #34495e; font-size: 1.1em;"><?php echo $ad->adTitle; ?></span><br>

                                <strong style="display: inline-block; width: 180px; color: #2c3e50; font-weight: 600; margin-bottom: 10px;">Advertisement Date:</strong>
                                <span style="color: #34495e;"><?php echo $ad->adDate; ?></span><br>

                                <strong style="display: inline-block; width: 180px; color: #2c3e50; font-weight: 600; margin-bottom: 10px;">Advertisement Description:</strong>
                                <span style="color: #34495e; line-height: 1.5;"><?php echo $ad->adDescription; ?></span><br>
                            </div>
                            <div class="image" style="flex: 0 0 300px; margin-left: 20px; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                <?php if ($ad->img): ?>
                                    <?php
                                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                                    $mimeType = $finfo->buffer($ad->img);
                                    ?>
                                    <img src="data:<?= $mimeType ?>;base64,<?= base64_encode($ad->img) ?>"
                                        alt="Advertisement image"
                                        style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;"
                                        onmouseover="this.style.transform='scale(1.05)'"
                                        onmouseout="this.style.transform='scale(1)'">
                                <?php else: ?>
                                    <img src="<?= ROOT ?>/assets/images/placeholder.jpg"
                                        alt="No image available"
                                        style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;"
                                        onmouseover="this.style.transform='scale(1.05)'"
                                        onmouseout="this.style.transform='scale(1)'">
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