<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([2]);?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?=ROOT?>/assets/css/JobProvider/reviews.css">
<link rel="stylesheet" href="<?=ROOT?>/assets/css/components/empty.css">


<div class="wrapper flex-row">
    <?php require APPROOT . '/views/seeker/seeker_sidebar.php'; ?>
    
    <div class="main-content-reviews">
        <div class="header">
            <div class="heading">Reviews</div>
        </div>
        <br>
        <div class="search-container">
            <input type="text" 
                class="search-bar" 
                placeholder="Search reviews"
                aria-label="Search">
        </div>
        <div class="reviews-container container">
            <?php if (!empty($data)): ?>
                <?php foreach ($data as $review): ?>
                    <div class="review-card container">
                        <div class="review-card-left flex-row">
                            <div class="pfp">
                                <?php if ($review->pp): ?>
                                    <?php
                                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                                    $mimeType = $finfo->buffer($review->pp);
                                    ?>
                                    <img src="data:<?= $mimeType ?>;base64,<?= base64_encode($review->pp) ?>" alt="reviewee Image" class="profile-pic-reviewed-employee">
                                <?php else: ?>
                                    <img src="<?= ROOT ?>/assets/images/default.jpg" alt="No image available" class="profile-pic-reviewed-employee">
                                <?php endif; ?>
                            </div>

                            <div class="review-details">
                                <h2><?= htmlspecialchars($review->revieweeName) ?></h2>
                                <p>Title: <?= htmlspecialchars($review->jobTitle) ?></p>
                                <p>JobID: <?= htmlspecialchars($review->jobID) ?></p>

                                <div style="display:flex; flex-direction:column; gap:20px">
                                    <div class="rating">
                                        <span>
                                            <?php for ($i = 0; $i < 5; $i++): ?>
                                                <?php if ($i < $review->rating): ?>
                                                    <i class="fa fa-star star-active mx-1"></i>
                                                <?php else: ?>
                                                    <i class="fa fa-star star-inactive mx-1"></i>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        </span>
                                    </div>

                                    <p class="review-text">
                                        <?= htmlspecialchars($review->content) ?>
                                    </p>
                                </div>
                                <hr>
                                <p>Date Reviewed: <?= htmlspecialchars($review->reviewDate) ?></p>
                                <p>Time Reviewed: <?= htmlspecialchars($review->reviewTime) ?></p>
                            </div>
                        </div>
                        <div class="complaint-actions flex-row">
                            <button class="btn-update" onClick="window.location.href='<?= ROOT ?>/seeker/review/<?= $review->jobID ?>';">Update</button>
                            <button class="btn-delete" onclick="confirmDelete(<?php echo $review->reviewID?>)">Delete</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-container">
                    <img src="<?=ROOT?>/assets/images/no-data.png" alt="No Employees" class="empty-icon">
                    <p class="empty-text">No Received Applications Found</p>
                </div>
            <?php endif; ?>
        </div>
        <div id="delete-confirmation" class="modal" style="display: none;">
            <div class="modal-content">
                <p>Are you sure you want to delete this review?</p>
                <button id="confirm-yes" class="popup-btn-delete-complaint">Yes</button>
                <button id="confirm-no" class="popup-btn-delete-complaint">No</button>
            </div>
            <form id="delete-form" method="POST" style="display: none;"></form>

        </div>

    </div>
</div>
<script>
    function confirmDelete(id) {
        var modal = document.getElementById('delete-confirmation');
        modal.style.display = 'flex';

        document.getElementById('confirm-yes').onclick = function() {
            var form = document.getElementById('delete-form');
            form.action = '<?= ROOT ?>/seeker/deleteReview/' + id;
            modal.style.display = 'none';

            form.submit();
        };

        document.getElementById('confirm-no').onclick = function() {
            modal.style.display = 'none';
        };
    }
</script>