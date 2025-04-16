<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/home/subscriptions.css">
<div class="wrapper flex-col" >
    <?php include APPROOT . '/views/components/navbar.php'; ?>

    <div class="plans-container flex-row">
        <?php if (is_array($plans) || is_object($plans)): ?>
            <?php foreach ($plans as $plan): ?>
                <div class="plan-card">
                    <div class="plan-details">
                        <h3 class="plan-name"><?= htmlspecialchars($plan->planName) ?></h3>
                        <p class="plan-price"><?= htmlspecialchars($plan->price) ?> LKR/Month</p>
                        <ul class="plan-features">
                            <li><?= htmlspecialchars($plan->postLimit) ?> Posts/month</li>
                            <li><?= htmlspecialchars($plan->description) ?></li>
                            <li><?= htmlspecialchars($plan->duration) ?> months</li>
                            <li><?= $plan->badge ? 'Verified Badge' : 'No Verified Badge' ?></li>
                        </ul>
                        <button class="plan-button">Choose Plan</button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>