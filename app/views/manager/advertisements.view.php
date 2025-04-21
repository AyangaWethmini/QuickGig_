<?php 
require APPROOT . '/views/inc/header.php'; 
require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([1]); 
?>

<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/manager.css">
<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/advertisements.css"> 

<?php include APPROOT . '/views/components/navbar.php'; ?>

<?php include APPROOT . '/views/components/deleteConfirmation.php'; ?>

<div class="wrapper flex-row">
    <?php require APPROOT . '/views/manager/manager_sidebar.php'; ?>

    <div class="main-content container">
        <!-- Header Section -->
        <div class="header flex-row justify-between align-center">
            <h2>Current Advertisements</h2>
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
                        <p class="description"><?= htmlspecialchars(substr($ad->adDescription, 0, 100)) . '...' ?></p>
                        <p class="contact">Link: <a href="<?= htmlspecialchars($ad->link) ?>"><?= htmlspecialchars(substr($ad->link, 0, 100)) . '...' ?></a></p>
                        <div class="status">
                            <span class="badge <?= $ad->adStatus == 'active' ? 'active' : 'inactive' ?>">
                                <?= $ad->adStatus == 'active' ? 'Active' : 'Inactive' ?>
                            </span>
                            <br>
                            <p class="text-grey">Clicks: <?= htmlspecialchars($ad->clicks) ?> | Views: <?= htmlspecialchars($ad->views) ?></p>
                        </div>
                    </div>
                    <div class="ad-actionbtns flex-col">
                        <button class="btn btn-accent" onclick="window.location.href='<?=ROOT?>/manager/updateAd/<?= htmlspecialchars($ad->advertisementID) ?>'">Edit</button>
                        <button class="btn btn-del" onclick="showConfirmation('Are you sure you want to delete the advertisement?', 
                                () => submitForm('<?= ROOT ?>/manager/deleteAd/<?= htmlspecialchars($ad->advertisementID) ?>'))">Delete</button>
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
        <?php
            include_once APPROOT . '/views/components/alertBox.php';
            if (isset($_SESSION['error'])) {
            echo '<script>showAlert("' . htmlspecialchars($_SESSION['error']) . '", "error");</script>';
            
            }
            if (isset($_SESSION['success'])) {
            echo '<script>showAlert("' . htmlspecialchars($_SESSION['success']) . '", "success");</script>';
            
            }
            unset($_SESSION['error']);
            unset($_SESSION['success']);
        ?>



        
            
    </div>

   
</div>

