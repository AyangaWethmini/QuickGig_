<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php';
protectRoute([2]); ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?= ROOT ?>/assets/css/JobProvider/reviews.css">

<div class="wrapper flex-row">
    <?php require APPROOT . '/views/jobProvider/jobProvider_sidebar.php'; ?>

    <div class="main-content-reviews">
        <div class="header">
            <div class="heading">Reviews</div>
        </div>
        <hr>
        <div class="search-container">
            <input type="text"
                class="search-bar"
                placeholder="Search reviews"
                aria-label="Search">
            <br><br>
            <div class="filter-container">
                <span>Sort by:</span>
                <select id="sortSelect" onchange="sortContent()">
                    <option value="recent">Latest</option>
                    <option value="views">Oldest</option>
                </select>
            </div>
        </div>
        <div class="reviews-container container">
            <?php if (!empty($data['reviews'])): ?>
                <?php foreach ($data['reviews'] as $review): ?>
                    <div class="review-card container">
                        <div class="review-card-left flex-row">
                            <div class="pfp">
                                <img src="<?= ROOT . $review->reviewerProfilePic ?>" alt="Profile Picture" class="profile-pic-reviewed-employee">
                            </div>

                            <div class="review-details">
                                <h2><?= htmlspecialchars($review->reviewerName) ?></h2>
                                <p><?= htmlspecialchars($review->jobTitle) ?></p>
                                <p><?= htmlspecialchars($review->reviewDate) ?></p>
                                <p><?= htmlspecialchars($review->reviewTime) ?></p>
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
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="margin:20px 0;">No reviews yet.</p>
            <?php endif; ?>
        </div>

    </div>
</div>