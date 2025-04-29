<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([3]);?>
<?php require APPROOT . '/views/components/navbar.php'; ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link href="<?=ROOT?>/assets/css/components/user_plan.css" rel="stylesheet">

<div class="wrapper flex-row">
    <?php require APPROOT . '/views/jobProvider/organization_sidebar.php'; ?>
    
    <?php require APPROOT . '/views/components/userPlan.php'; ?>
   

    </div>

</div>




<?php require APPROOT . '/views/inc/footer.php'; ?>