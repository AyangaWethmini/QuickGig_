<?php require APPROOT . '/views/inc/header.php';  ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([3]);?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?=ROOT?>/assets/css/user/messages.css">

<body>

<div class="wrapper flex-row">
    
    <?php require APPROOT . '/views/jobProvider/organization_sidebar.php'; ?>
    
    <div class="no-messages-container">
        <img src="<?=ROOT?>/assets/images/no-messages.png" alt="No Messages" class="no-messages-icon">
        <p class="no-messages-text">No Messages Yet</p>
    </div>

</div>

</body>