<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?= ROOT ?>/assets/css/home/home.css">
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/user/premium.css">

<div class="main-premium" style="background: linear-gradient(180deg, var(--brand-primary) 0%, #f8fbff 100%); height: 100vh; padding: 20px;">
    

    <main class="container">

        <h2 class="premium-title">Premium Plans</h2>
        <div class="plans-container">
            <?php if (is_array($plans) || is_object($plans)): ?>
                <?php foreach ($plans as $plan): ?>
                    <div class="plan-card">
                        <div class="plan-details">
                            <h3 class="plan-name"><?= htmlspecialchars($plan->planName) ?></h3>
                            <p class="plan-price"><?= htmlspecialchars($plan->price) ?> LKR/Month</p>
                            <ul class="plan-features">
                                <li><?= $plan->postLimit == 10000 ? 'Unlimited' : htmlspecialchars($plan->postLimit) ?> Posts/month</li>
                                <li><?= htmlspecialchars($plan->description) ?></li>

                                <?php if ($plan->planID != -1): ?>
                                    <li><?= htmlspecialchars($plan->duration) ?> months</li>
                                <?php endif; ?>
                                <li><?= $plan->badge ? 'Verified Badge' : 'No Verified Badge' ?></li>
                            </ul>
                            <?php if ($plan->planID != -1): ?>
                                <form method="POST" action="<?= ROOT ?>/subscription/subscribe">
                                    <input type="hidden" name="priceID" value="<?= htmlspecialchars($plan->stripe_price_id) ?>">
                                    <input type="hidden" name="planID" value="<?= htmlspecialchars($plan->planID) ?>">
                                    <button class="plan-button" type="submit">Choose Plan</button>
                                </form><?php endif; ?>

                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

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
<footer class="footer" style="background-color: black;">
    <div class="footer-content">
        <div class="footer-logo-section">
            <img src="<?= ROOT ?>/assets/images/QuickGiglLogo.png" alt="QuickGig Logo" class="footer-logo" />
            <p class="footer-text">
                Great platform for job seekers who<br>
                are passionate about startups. Find<br>
                your dream job easier.
            </p>
        </div>

        <div class="footer-links">
            <a href="<?= ROOT ?>/home/aboutUs">About Us</a>
            <a href="<?= ROOT ?>/home/contact">Contact Us</a>
        </div>
    </div>

    <hr class="footer-divider">
    <p class="copyright">&copy; 2024 QuickGig. All rights reserved.</p>
</footer>