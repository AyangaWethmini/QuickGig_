<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([2]);?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?= ROOT ?>/assets/css/user/messages.css">

<body>

    <div class="wrapper flex-row">
        <?php require APPROOT . '/views/jobProvider/jobProvider_sidebar.php'; ?>
        <div class="individual-announcements-container">
            <?php if (!empty($data['announcements'])): ?>
                <?php foreach ($data['announcements'] as $announcement): ?>
                    <div class="announcement-container">
                        <div class="the-complaint"><?php echo $announcement->content; ?></div>
                        <div class="text-grey">
                            <?php
                            $formattedTime = date('h:i A', strtotime($announcement->announcementTime));
                            echo $announcement->announcementDate;
                            ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>