<?php 
require APPROOT . '/views/inc/header.php'; 
require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([1]); 
?>

<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/manager.css">
<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/advertisements.css"> 

<?php include APPROOT . '/views/components/navbar.php'; ?>

<?php include APPROOT . '/views/components/deleteConfirmation.php'; ?>

<div class="wrapper flex-row">
    <?php require APPROOT . '/views/manager/manager_sidebar.php'; ?>

    <div class="main-content container">
        
        <div class="header flex-row justify-between align-center">
            <h2>Advertisers</h2>
             
        </div>
        <hr>

        <div class="advertisers">
                        <h3>Advertisers</h3>
                        <table class="advertiser-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <!-- <th>Options</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($advertisers as $advertiser): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($advertiser->advertiserName) ?></td>
                                        <td><?= htmlspecialchars($advertiser->email) ?></td>
                                        <td><?= htmlspecialchars($advertiser->contact) ?></td>
                                        
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

        

            
        </div> 

        
        <!-- Error Message -->
        <?php
            include_once APPROOT . '/views/components/alertBox.php';
            if (isset($_SESSION['error'])) {
                echo '<script>showAlert("' . htmlspecialchars($_SESSION['error']) . '", "error");</script>';
            }
            if (isset($_SESSION['success'])) {
                echo '<script>showAlert("' . htmlspecialchars($_SESSION['success']) . '", "success");</script>';
            }
            unset($_SESSION['error']);
            unset($_SESSION['success']);
        ?>



        
            
    </div>

   
</div>

