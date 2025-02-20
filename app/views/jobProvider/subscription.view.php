<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([2]);?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?=ROOT?>/assets/css/jobProvider/subscription.css">

<body>
<script src="<?=ROOT?>/assets/js/jobProvider/jobListing.js"></script>
<div class="wrapper flex-row">
    <?php require APPROOT . '/views/jobProvider/jobProvider_sidebar.php'; ?>
    <div class="inclusion-container-subscription">
        
        <div class="subscription-plan">
            <div class="subscription-plan-name">Basic</div>
            <div class="subscription-plan-price">$15.00/Month</div>
            <ul class="subscription-plan-options">
                <li>10 Posts per month</li>
                <li>Messaging</li>
            </ul>
            <button class="subscription-plan-btn">Select Plan</button>
        </div>

        <div class="subscription-plan">
            <div class="subscription-plan-name">Standard</div>
            <div class="subscription-plan-price">$25.00/Month</div>
            <ul class="subscription-plan-options">
                <li>25 Posts per month</li>
                <li>Messaging</li>
                <li>Scheduling</li>
            </ul>
            <button class="subscription-plan-btn">Select Plan</button>
        </div>

        <div class="subscription-plan">
            <div class="subscription-plan-name">Premium</div>
            <div class="subscription-plan-price">$35.00/Month</div>
            <ul class="subscription-plan-options">
                <li>Unlimited Posts</li>
                <li>Messaging</li>
                <li>Scheduling</li>
                <li>verified Badge</li>
            </ul>
            <button class="subscription-plan-btn">Select Plan</button>
        </div>

    </div>
</div>