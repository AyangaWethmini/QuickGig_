<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([2]);?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

    
<?php include APPROOT . '/views/seeker/seeker_sidebar.php'; ?>
<?php require APPROOT . '/views/components/user_report.php'; ?>

<?php require APPROOT . '/views/inc/footer.php'; ?>