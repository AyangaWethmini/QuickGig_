<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([2]);?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?=ROOT?>/assets/css/jobProvider/subscription.css">

<body>
<div class="wrapper flex-row">
    <?php require APPROOT . '/views/seeker/seeker_sidebar.php'; ?>
    <div class="inclusion-container-subscription">
        
        <div class="subscription-plan">
            <div class="subscription-plan-name">Basic</div>
            <div class="subscription-plan-price">$15.00/Month</div>
            <ul class="subscription-plan-options">
                <li>Verified Badge</li>
                <li>10 Posts per month</li>
                <li>ztututu</li>
                <li>bruh</li>
            </ul>
            <button class="subscription-plan-btn">Select Plan</button>
        </div>

        <div class="subscription-plan">
            <div class="subscription-plan-name">Standard</div>
            <div class="subscription-plan-price">$25.00/Month</div>
            <ul class="subscription-plan-options">
                <li>Verified Badge</li>
                <li>20 Posts per month</li>
                <li>ztututu</li>
                <li>bruh</li>
            </ul>
            <button class="subscription-plan-btn">Select Plan</button>
        </div>

        <div class="subscription-plan">
            <div class="subscription-plan-name">Premium</div>
            <div class="subscription-plan-price">$35.00/Month</div>
            <ul class="subscription-plan-options">
                <li>Verified Badge</li>
                <li>Unlimited Posts</li>
                <li>ztututu</li>
                <li>bruh</li>
            </ul>
            <button class="subscription-plan-btn">Select Plan</button>
        </div>

    </div>
</div>