<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php';
protectRoute([0]); ?>
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/admin/admin_announcement.css">
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/admin/admin_advertisement.css">

<?php include APPROOT . '/views/components/navbar.php';
?>

<div class="admin-layout">
    <?php require APPROOT . '/views/components/admin_sidebar.php'; ?>
    <div class="admin-container">
        <div class="admin-announcement-filterheader">
            <h1 style="font-size: 2.5rem;"><strong>All Advertisements</strong></h1>
            <hr>
        </div>
        <div class="complaints-container container" style="margin-bottom: 5px;">
            <?php if (empty($data['ads'])): ?>
                <div class="no-results">
                    No advertisements found.
                </div>
            <?php else: ?>
                <?php foreach ($data['ads'] as $ad): ?>
                    <div class="complaint">
                        <div class="complaint-details">
                            <div class="admin-ad">
                                <div>
                                    <strong>Advertisement ID:</strong>
                                    <span><?php echo $ad->advertisementID; ?></span>
                                </div>

                                <div>
                                    <strong>Advertisement Title:</strong>
                                    <span class="title"><?php echo $ad->adTitle; ?></span>
                                </div>

                                <div>
                                    <strong>Start Date:</strong>
                                    <span><?php echo $ad->startDate; ?></span>
                                </div>

                                <div>
                                    <strong>End Date:</strong>
                                    <span><?php echo $ad->endDate; ?></span>
                                </div>

                                <div>
                                    <strong>Advertisement Description:</strong>
                                    <span class="description"><?php echo $ad->adDescription; ?></span>
                                </div>
                            </div>
                            <div class="image">
                                <?php if ($ad->img): ?>
                                    <?php
                                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                                    $mimeType = $finfo->buffer($ad->img);
                                    ?>
                                    <img src="data:<?= $mimeType ?>;base64,<?= base64_encode($ad->img) ?>"
                                        alt="Advertisement image"
                                        onmouseover="this.style.transform='scale(1.05)'"
                                        onmouseout="this.style.transform='scale(1)'">
                                <?php else: ?>
                                    <img src="<?= ROOT ?>/assets/images/placeholder.jpg"
                                        alt="No image available"
                                        onmouseover="this.style.transform='scale(1.05)'"
                                        onmouseout="this.style.transform='scale(1)'">
                                <?php endif; ?>
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

                <!-- Page numbers - limited to 3 visible pages -->
                <?php
                $totalPages = max(1, $data['totalPages']);
                $currentPage = $data['currentPage'];

                // Calculate which pages to show (max 3)
                if ($totalPages <= 3) {
                    // If 3 or fewer pages, show all
                    $startPage = 1;
                    $endPage = $totalPages;
                } else {
                    // Show 3 pages centered around current page when possible
                    if ($currentPage <= 2) {
                        $startPage = 1;
                        $endPage = 3;
                    } elseif ($currentPage >= $totalPages - 1) {
                        $startPage = $totalPages - 2;
                        $endPage = $totalPages;
                    } else {
                        $startPage = $currentPage - 1;
                        $endPage = $currentPage + 1;
                    }
                }

                // Generate the page links
                for ($i = $startPage; $i <= $endPage; $i++):
                ?>
                    <a href="<?= ROOT ?>/admin/adminadvertisements?page=<?= $i ?>"
                        class="page-link <?= $i == $currentPage ? 'active' : '' ?>">
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
    .complaint {
        padding: 30px;
    }

    .complaint-details {
        display: flex;
        flex-direction: row;
        align-items: flex-start;
        gap: 20px;
    }

    .admin-ad {
        flex: 1;
        padding: 10px;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
    }

    .admin-ad div {
        display: flex;
        margin-bottom: 25px;
    }

    .admin-ad strong {
        display: inline-block;
        width: 300px;
        color: #2c3e50;
        font-size: 20px;
        font-weight: 600;
    }

    .admin-ad span {
        font-size: 19px;
        color: #34495e;
        flex: 1;
    }

    .admin-ad span.title {
        font-size: 1.1em;
    }

    .admin-ad span.description {
        line-height: 1.5;
    }

    .image {
        flex: 0 0 400px;
        height: 220px;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
    }

    .image img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        transition: transform 0.3s ease;
        max-width: 100%;
        max-height: 100%;
    }
</style>

<?php require APPROOT . '/views/inc/footer.php'; ?>