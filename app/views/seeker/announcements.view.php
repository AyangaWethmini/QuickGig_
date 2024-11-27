<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?=ROOT?>/assets/css/user/messages.css">

<body>

<div class="wrapper flex-row">
    
    <?php require APPROOT . '/views/seeker/seeker_sidebar.php'; ?>
    
    <div class="no-messages-container">
        <img src="<?=ROOT?>/assets/images/no-announcement.png" alt="No Messages" class="no-messages-icon">
        <p class="no-messages-text">No Announcements Yet</p>
    </div>

</div>

</body>