<?php 
require APPROOT . '/views/inc/header.php'; 
require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([1]); 
?>

<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/manager.css">
<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/advertisements.css"> 

<?php include APPROOT . '/views/components/navbar.php'; ?>

<div class="wrapper flex-row">
    <?php require APPROOT . '/views/manager/manager_sidebar.php'; ?>

    <div class="main-content container">
        <!-- Header Section -->
        <div class="header flex-row justify-between align-center">
            <h3>Current Advertisements</h3>
            <button class="btn btn-accent" onclick="window.location.href='<?=ROOT?>/manager/createAd'"> + Post Advertisement</button>
        </div>
        <hr>

        <!-- Filter Section -->
        <div class="filter flex-row justify-between align-center">
            <div>
                <h3>All Ads</h3>
                <p class="text-grey">Showing <?= count($advertisements) ?> results</p>
            </div>
        </div>

        <!-- Advertisement Cards -->
        <div class="ads-wrapper">
            <div class="ads container">
                <?php 
                $adsPerPage = 3;
                $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $startIndex = ($currentPage - 1) * $adsPerPage;
                $counter = 0;

                for ($i = $startIndex; $i < count($advertisements) && $counter < $adsPerPage; $i++): 
                    $ad = $advertisements[$i];
                    $counter++;
                ?> 
                <div class="ad-card flex-row">
                    <div class="image">
                        <?php if ($ad->img): ?>
                            <?php 
                                $finfo = new finfo(FILEINFO_MIME_TYPE);
                                $mimeType = $finfo->buffer($ad->img);
                            ?>
                            <img src="data:<?= $mimeType ?>;base64,<?= base64_encode($ad->img) ?>" alt="Ad image" style="width: 200px; height: 200px;">
                        <?php else: ?>
                            <img src="<?=ROOT?>/assets/images/placeholder.jpg" alt="No image available">
                        <?php endif; ?>
                    </div>
                    <div class="ad-details flex-col">
                        <p class="adv-title"><strong><?= htmlspecialchars($ad->adTitle) ?></strong></p>
                        <p class="advertiser">Advertiser ID: <?= htmlspecialchars($ad->advertiserID) ?></p>
                        <p class="description"><?= htmlspecialchars(implode(' ', array_slice(explode(' ', $ad->adDescription), 0, 10))) . '...' ?></p>
                        <p class="contact">Link: <a href="<?= htmlspecialchars($ad->link) ?>"><?= htmlspecialchars($ad->link) ?></a></p>
                        <div class="status">
                            <span class="badge <?= $ad->adStatus == 1 ? 'active' : 'inactive' ?>">
                                <?= $ad->adStatus == 'active' ? 'Active' : 'Inactive' ?>
                            </span>
                        </div>
                    </div>
                    <div class="ad-actionbtns flex-col">
                        <button class="btn btn-accent" onclick="window.location.href='<?=ROOT?>/manager/updateAd/<?= htmlspecialchars($ad->advertisementID) ?>'">Edit</button>
                        <button class="btn btn-del" onclick="deleteAd(<?= $ad->advertisementID ?>)">Delete</button>
                    </div>
                </div>
                <?php endfor; ?>
            </div>
        </div>

        <!-- Pagination -->
        <div class="pagination flex-row">
            <?php
            $totalPages = ceil(count($advertisements) / $adsPerPage);
            if ($currentPage > 1): ?>
                <a href="?page=<?= $currentPage - 1 ?>" class="btn btn-trans">Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i ?>" class="btn <?= $i === $currentPage ? 'btn-accent' : 'btn-trans' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>

            <?php if ($currentPage < $totalPages): ?>
                <a href="?page=<?= $currentPage + 1 ?>" class="btn btn-trans">Next</a>
            <?php endif; ?>
        </div>

        <!-- Error Message -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
    </div>
</div>

<script>
function deleteAd(adId) {
    if (confirm('Are you sure you want to delete this advertisement?')) {
        fetch(`<?=ROOT?>/manager/deleteAdvertisement/${adId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            }
        })
        .then(response => {
            if (response.ok) {
                alert('Advertisement deleted successfully');
                window.location.reload();
            } else {
                alert('Failed to delete advertisement');
            }
        });
    }
}
</script>
