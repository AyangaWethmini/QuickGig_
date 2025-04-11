<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php';
protectRoute([0]); ?>
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/admin/admin_announcement.css">
<?php include APPROOT . '/views/components/navbar.php';
?>


<div class="admin-layout">
    <?php require APPROOT . '/views/components/admin_sidebar.php'; ?>
    <div class="admin-container">
        <div class="admin-announcement-filterheader">
            <h1>All Advertisements</h1>
        </div>
        <div class="complaints-container container">
            <?php if (empty($data['ads'])): ?>
                <div class="no-results">
                    No advertisements found.
                </div>
            <?php else: ?>
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
            <?php endif; ?>
        </div>

        <div class="pagination-container">
            <div class="pagination">
                <!-- Previous button -->
                <a href="<?= ROOT ?>/admin/adminadvertisements?page=<?= max(1, $data['currentPage'] - 1) ?>"
                    class="page-link <?= $data['currentPage'] <= 1 ? 'disabled' : '' ?>">
                    &laquo;
                </a>

                <!-- Page numbers -->
                <?php for ($i = 1; $i <= max(1, $data['totalPages']); $i++): ?>
                    <a href="<?= ROOT ?>/admin/adminadvertisements?page=<?= $i ?>"
                        class="page-link <?= $i == $data['currentPage'] ? 'active' : '' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>

                <!-- Next button -->
                <a href="<?= ROOT ?>/admin/adminadvertisements?page=<?= min($data['totalPages'], $data['currentPage'] + 1) ?>"
                    class="page-link <?= $data['currentPage'] >= $data['totalPages'] ? 'disabled' : '' ?>">
                    &raquo;
                </a>
            </div>
            <div class="pagination-info">
                (Total advertisements: <?= $data['totalAds'] ?>)
            </div>
        </div>
    </div>
</div>

<style>
    .admin-container {
        position: relative;
        min-height: 600px;
        padding-bottom: 100px;
    }

    .complaints-container {
        flex: 1;
        min-height: 400px;
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin-bottom: 60px;
        width: 90%;
    }

    .pagination-container {
        position: absolute;
        bottom: 110px;
        left: 0;
        right: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        background-color: white;
        padding: 15px 0;
        margin: 0;
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
        min-width: 300px;
    }

    .page-link {
        padding: 8px 16px;
        min-width: 40px;
        text-align: center;
        border: 1px solid rgb(198, 198, 249);
        border-radius: 4px;
        text-decoration: none;
        color: #333;
        transition: all 0.3s ease;
    }

    .page-link.disabled {
        opacity: 0.5;
        pointer-events: none;
        background-color: #f0f0f0;
    }

    .page-link:hover:not(.disabled) {
        background-color: rgb(198, 198, 249);
        color: white;
    }

    .page-link.active {
        background-color: rgb(198, 198, 249);
        color: white;
    }

    .pagination-info {
        color: #666;
        font-size: 0.9em;
    }

    .no-results {
        text-align: center;
        padding: 30px;
        color: #666;
        font-size: 16px;
        background-color: #f9f9f9;
        border-radius: 8px;
        margin: 20px 0;
    }
</style>

<?php require APPROOT . '/views/inc/footer.php'; ?>