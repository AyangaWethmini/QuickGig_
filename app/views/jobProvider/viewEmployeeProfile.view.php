<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php';
protectRoute([2]); ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?= ROOT ?>/assets/css/jobProvider/individualProfile.css">
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/jobProvider/viewEmployeeProfile.css">
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/jobProvider/reviews.css">
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/jobProvider/jobListing.css">


<body>
    <div class="background-image" style="background-image: url('<?= ROOT ?>/assets/images/background.jpg');">

        <div class="wrapper flex-row">
        <?php require APPROOT . '/views/jobProvider/jobProvider_sidebar.php'; ?>

            <div class="profile-container">
                <div class="profile-header">
                    <div class="profile-info" style="background-image: url('<?= ROOT ?>/assets/images/profileBack.jpg');">
                        <div class="profile-overlay">
                            <img id="profile-preview" class="edit-profile-photo"
                                src="<?= !empty($data['pp']) ? 'data:image/jpeg;base64,' . base64_encode($data['pp']) : ROOT . '/assets/images/default.jpg' ?>"
                                alt="Profile Photo">

                            <div class="profile-intro-cover">
                                <div class="profile-intro">
                                    <div class="flex-row fit-content">
                                        <h2><?= htmlspecialchars(($data['fname'] ?? '') . ' ' . ($data['lname'] ?? '')) ?></h2>
                                        <?php if ($data['badge'] == 1): ?>
                                            <img src="<?= ROOT ?>/assets/images/crown.png" class="verify-badge-profile" alt="Verified Badge">
                                        <?php endif; ?>
                                    </div>
                                    <p class="location-text"><?= htmlspecialchars(($data['city'] ?? '') . ',' . ($data['district'] ?? '')) ?></p>
                                </div>

                                <div class="sendmsg">
                                    <a href="<?= ROOT ?>/message/startConversation/<?= $data['accountID'] ?>">
                                        <button class="sendmsg-btn">Send Message</button>
                                    </a>
                                </div>
                            </div>
                        </div>



                    </div>

                    <div class="profile-contacts">
                        <div class="additional-details">
                            <h2>Additional Details</h2> <br>
                            <p class="title-items">Email</p>
                            <p class="detail-items"><?= htmlspecialchars(($data['email'] ?? 'No email given')) ?></p><br>
                            <p class="title-items">Phone</p>
                            <p class="detail-items"><?= htmlspecialchars(($data['phone'] ?? 'No number given')) ?></p><br>
                        </div>
                        <div class="social-links">
                            <h2>Social Links</h2> <br>
                            <p class="title-items">LinkedIn</p>
                            <p class="detail-items"><?= htmlspecialchars(($data['linkedin'] ?? 'No link given')) ?></p><br>
                            <p class="title-items">facebook</p>
                            <p class="detail-items"><?= htmlspecialchars(($data['facebook'] ?? 'No link given')) ?></p><br>
                        </div>
                    </div>
                </div>
                <div class="profile-about">
                    <h3>About Me</h3>
                    <p><?= htmlspecialchars(($data['bio'] ?? '')) ?></p>
                </div>


                <div class="rating-reviews">
                    <h3>Rating and Reviews</h3>
                    <div class="rating">
                        <div class="container-fluid px-1 py-5 mx-auto flex">
                            <div class="row justify-content-center">
                                <div class="col-xl-7 col-lg-8 col-md-10 col-12 text-center mb-5">
                                    <div class="card">
                                        <div class="col-md-4 d-flex flex-row">
                                            <div class="col-md-4 d-flex flex-column">
                                                <div class="rating-box">
                                                    <p class="pt-4 rate"><?= number_format($avgRate, 1) ?></p>

                                                </div>
                                                <div class="rating-stars">
                                                    <?php
                                                    $stars = 5;
                                                    $remaining = $avgRate;

                                                    for ($i = 0; $i < $stars; $i++) {
                                                        if ($remaining >= 1) {
                                                            echo '<img src="' . ROOT . '/assets/images/fullstar.png" class="star-img">';
                                                            $remaining -= 1;
                                                        } elseif ($remaining > 0.5) {
                                                            echo '<img src="' . ROOT . '/assets/images/threequarterstar.png" class="star-img">';
                                                            $remaining = 0;
                                                        } elseif ($remaining == 0.5) {
                                                            echo '<img src="' . ROOT . '/assets/images/halfstar.png" class="star-img">';
                                                            $remaining = 0;
                                                        } elseif ($remaining < 0.5 && $remaining > 0) {
                                                            echo '<img src="' . ROOT . '/assets/images/quarterstar.png" class="star-img">';
                                                            $remaining = 0;
                                                        } else {
                                                            echo '<img src="' . ROOT . '/assets/images/emptystar.png" class="star-img">';
                                                        }
                                                    }
                                                    ?>
                                                </div>

                                            </div>
                                            <?php
                                            $totalRatings = array_sum($data['ratings']);
                                            function getBarWidth($count, $total)
                                            {
                                                return $total > 0 ? ($count / $total) * 100 : 0;
                                            }
                                            ?>
                                            <div class="bar-block">
                                                <div class="rating-bar0 justify-content-center">
                                                    <table class="text-left mx-auto">
                                                        <?php
                                                        $labels = ['5' => 'Excellent', '4' => 'Good', '3' => 'Average', '2' => 'Poor', '1' => 'Terrible'];
                                                        foreach ($labels as $star => $label) :
                                                            $count = $data['ratings'][$star];
                                                            $width = getBarWidth($count, $totalRatings);
                                                        ?>
                                                            <tr>
                                                                <td class="rating-label"><?= $label ?></td>
                                                                <td class="rating-bar">
                                                                    <div class="bar-container">
                                                                        <div class="bar-<?= $star ?>" style="width: <?= $width ?>%;"></div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-right"><?= $count ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="reviews-section">

                    <?php if (!empty($reviews) && is_array($reviews)): ?>
                        <?php foreach ($reviews as $review): ?>
                            <?php if (!is_object($review)) continue; ?>
                            <div class="review-card container">
                                <div class="review-card-left flex-row">
                                    <div class="pfp">
                                        <a href="<?= ROOT ?>/jobProvider/viewEmployeeProfile/<?= $review->reviewerID ?>">
                                            <img src="<?= !empty($review->pp) ? 'data:image/jpeg;base64,' . base64_encode($review->pp) : ROOT . '/assets/images/default.jpg' ?>">
                                        </a>
                                    </div>

                                    <div class="review-details">
                                        <h2><?= htmlspecialchars($review->reviewerName) ?></h2>
                                        <p>Title: <?= htmlspecialchars($review->jobTitle) ?></p>
                                        <p>JobID: <?= htmlspecialchars($review->jobID) ?></p>
                                        <div style="display:flex;flex-direction:column; gap:20px">
                                            <div class="rating">
                                                <span>
                                                    <?php for ($i = 0; $i < 5; $i++): ?>
                                                        <i class="fa fa-star <?= $i < $review->rating ? 'star-active' : 'star-inactive' ?> mx-1"></i>
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
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-container">
                            <img src="<?= ROOT ?>/assets/images/no-data.png" alt="No Employees" class="empty-icon">
                            <p class="empty-text">No Reviews Found</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>


        </div>
    </div>
    </div>