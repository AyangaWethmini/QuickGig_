<link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/subscription_popup.css">

<div class="ads-popup">
    <div class="ads flex-row">
        <div class="cards flex-col">
            <?php if (is_array($plans) || is_object($plans)): ?>
                <?php foreach ($plans as $plan): ?>
                    <div class="plan-card" style="background-image: url('<?= htmlspecialchars($plan->img) ?>');">
                        <div class="subscription-plan-name"><?= htmlspecialchars($plan->planName) ?></div>
                        <div class="subscription-plan-price">$<?= htmlspecialchars($plan->price) ?>/Month</div>
                        <ul class="subscription-plan-options">
                            <li><?= htmlspecialchars($plan->postLimit) ?>Posts/ month</li>
                            <li><?= htmlspecialchars($plan->description) ?></li>
                            <li><?= htmlspecialchars($plan->duration) ?> months</li>
                            <li><?= $plan->badge ? 'Verified Badge' : 'No Verified Badge' ?></li>
                        </ul>

                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <button class="btn btn-accent" onclick="window.location.href='<?= ROOT ?>/manager/updatePlan/<?= $plan->planID ?>'">Start Trial</button>
    </div>

</div>