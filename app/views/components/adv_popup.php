<link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/subscription_popup.css">
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/styles.css">

<div class="sub-background" style="display: flex; justify-content: center; align-items: center; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.7); z-index: 1000;">
    <div class="subscription-popup" style="background: white; padding: 30px; border-radius: 12px; max-width: 600px; width: 90%; position: relative;">
        <!-- Close button -->
        <button onclick="hideSubscriptionPopup()" style="position: absolute; top: 10px; right: 10px; background: none; border: none; font-size: 20px; cursor: pointer;">&times;</button>

        <div class="ad-container" style="display: flex; gap: 20px; margin-bottom: 20px;">
            <div class="image" style="flex: 0 0 200px;">
                <?php if ($ad->img): ?>
                    <?php
                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                    $mimeType = $finfo->buffer($ad->img);
                    ?>
                    <img src="data:<?= $mimeType ?>;base64,<?= base64_encode($ad->img) ?>" alt="Advertisement image" style="width: 200px; height: 200px; object-fit: cover; border-radius: 8px;">
                <?php else: ?>
                    <img src="<?= ROOT ?>/assets/images/placeholder.jpg" alt="No image available" style="width: 200px; height: 200px; object-fit: cover; border-radius: 8px;">
                <?php endif; ?>
            </div>
            <div class="ad-content" style="flex: 1;">
                <h2 style="margin: 0 0 10px 0; color: #333;"><?= htmlspecialchars($ad->adTitle) ?></h2>
                <p style="margin: 0 0 15px 0; color: #666; line-height: 1.5;">
                    <?= htmlspecialchars($ad->adDescription) ?>
                </p>
                <?php if ($ad->link): ?>
                    <a href="<?= htmlspecialchars($ad->link) ?>" target="_blank" class="btn" style="display: inline-block; margin-bottom: 15px; text-decoration: none;">Learn More</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="trial-button" style="display: flex; gap: 10px; justify-content: center;">
            <button class="btn" onclick="window.location.href='<?= ROOT ?>/home/subscriptions'" style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">Start Free Trial</button>
            <button class="btn" onclick="hideSubscriptionPopup()" style="padding: 10px 20px; background-color: #6c757d; color: white; border: none; border-radius: 5px; cursor: pointer;">No, Thanks!</button>
        </div>
    </div>
</div>