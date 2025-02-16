<link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/subscription_popup.css">
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/styles.css">

<div class="sub-background" style="display: flex; justify-content: center; align-items: center; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.7); z-index: 1000;">
    <div class="subscription-popup" style="background: white; padding: 20px; border-radius: 8px; max-width: 500px; width: 100%;">
        <div class="popup-header">
            <h2>Do more with Quickgig Premium</h2>
        </div>
        <div class="plans-container">
            <?php if (is_array($plans) || is_object($plans)): ?>
                <?php foreach ($plans as $plan): ?>
                    <div class="plan-card">
                        <div class="plan-image" style="background-image: url('<?= htmlspecialchars($plan->img) ?>'); background-color: #f0f0f0;"></div>
                        <div class="plan-details">
                            <h3 class="plan-name"><?= htmlspecialchars($plan->planName) ?></h3>
                            <p class="plan-price"><?= htmlspecialchars($plan->price) ?> LKR/Month</p>
                            <ul class="plan-features" style="list-style-type: disc;">
                                <li><?= htmlspecialchars($plan->postLimit) ?> Posts/month</li>
                                <li><?= htmlspecialchars($plan->description) ?></li>
                                <li><?= htmlspecialchars($plan->duration) ?> months</li>
                                <li><?= $plan->badge ? 'Verified Badge' : 'No Verified Badge' ?></li>
                            </ul>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="trial-button flex-row">
            <button class="btn" onclick="window.location.href='<?= ROOT ?>/manager/updatePlan/<?= $plan->planID ?>'">Start Free Trial</button>
            <button class="btn" onclick="hideSubscriptionPopup()">No, Thanks!</button>
        </div>
    </div>
</div>