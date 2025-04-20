<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php';
protectRoute([2]); ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?= ROOT ?>/assets/css/user/review.css">

<body>

    <div class="wrapper flex-row">

        <?php require APPROOT . '/views/seeker/seeker_sidebar.php'; ?>

        <div class="review-section">

            <h2>Rate and Review</h2>
            <div class="review-user-info">
                <div class="profile-photo">
                    <?php if ($data['pp']): ?>
                        <?php
                        $finfo = new finfo(FILEINFO_MIME_TYPE);
                        $mimeType = $finfo->buffer($data['pp']);
                        ?>
                        <img src="data:<?= $mimeType ?>;base64,<?= base64_encode($data['pp']) ?>" alt="reviewee Image" class="profile-photo">
                    <?php else: ?>
                        <img src="<?= ROOT ?>/assets/images/default.jpg" alt="No image available" class="profile-photo">
                    <?php endif; ?>
                </div>
                <h3 class="receiver-name"><?= $data['fname'] . ' ' . $data['lname'] ?></h3>
            </div>
            <!-- Review submission form -->
            <form action="<?= ROOT ?>/jobProvider/addReview/<?=$data['accountID']?>" method="POST" class="review-form">
                <input type="hidden" name="receiver_id" value="<?= $receiverId ?>">
                <input type="hidden" name="rating" id="rating-value" value="">
                <input type="hidden" name="reviewDate" value="<?=date('Y-m-d')?>">
                <input type="hidden" name="reviewTime" value="<?=date('H:i:s')?>">


                <label for="rating">Rating:</label>
                <div class="star-rating">
                    <span class="star" data-value="1">&#9733;</span>
                    <span class="star" data-value="2">&#9733;</span>
                    <span class="star" data-value="3">&#9733;</span>
                    <span class="star" data-value="4">&#9733;</span>
                    <span class="star" data-value="5">&#9733;</span>
                </div>

                <label for="review">Review:</label>
                <textarea name="review" id="review" rows="4" placeholder="Write your review..." required></textarea>

                <button type="submit" class="btn-submit-review">Submit Review</button>
            </form>

        </div>


    </div>
    <script>
        const stars = document.querySelectorAll('.star-rating .star');
        const ratingValue = document.getElementById('rating-value');

        stars.forEach(star => {
            star.addEventListener('click', () => {
                const value = star.getAttribute('data-value');
                ratingValue.value = value;

                // Remove selected class from all stars
                stars.forEach(s => s.classList.remove('selected'));

                // Add selected class up to the clicked star
                stars.forEach(s => {
                    if (s.getAttribute('data-value') <= value) {
                        s.classList.add('selected');
                    }
                });
            });

            star.addEventListener('mouseover', () => {
                const value = star.getAttribute('data-value');
                stars.forEach(s => {
                    if (s.getAttribute('data-value') <= value) {
                        s.classList.add('hover');
                    }
                });
            });

            star.addEventListener('mouseout', () => {
                stars.forEach(s => s.classList.remove('hover'));
            });
        });
    </script>


</body>