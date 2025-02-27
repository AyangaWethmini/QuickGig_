<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php';
protectRoute([1]); ?>
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/manager/report.css">
<?php include APPROOT . '/views/components/navbar.php'; ?>

<div class="wrapper flex-row" style="margin-top: 100px;">
    <?php require APPROOT . '/views/manager/manager_sidebar.php'; ?>
    <div class="main-content">
        <div class="flex-container">
            <div class="flex-item">1</div>
            <div class="flex-item">2</div>
            <div class="flex-item">3</div>
            <div class="flex-item">4</div>
        </div>
    </div>

</div>


<?php require APPROOT . '/views/inc/footer.php'; ?>