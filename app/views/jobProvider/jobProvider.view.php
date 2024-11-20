<?php require APPROOT . '/views/inc/header.php'; ?>

<body>
    <div class="flex-col">
        <?php require APPROOT . '/views/components/navbar.php'; ?>
        <div class="flex-row" >
            <?php require APPROOT . '/views/jobProvider/jobProvider_sidebar.php'; ?>
            <?php require APPROOT . '/views/jobProvider/individualProfile.php'; ?>
        </div> sidebar loads under the navbar where navbar covers half of the sidebar. i want to make it so that the side bar loads below the navbar 
    </div>
</body>
