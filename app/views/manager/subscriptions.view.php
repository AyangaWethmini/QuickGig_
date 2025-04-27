<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([1]); ?>
<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/plan.css"> 
<?php include APPROOT . '/views/components/navbar.php'; ?>

<div class="wrapper flex-row" style="margin-top: 100px;">
    <?php require APPROOT . '/views/manager/manager_sidebar.php'; ?>
    
    <div class="main-content">
        <div class="plans-section">
            
            <div class="plan-header flex-row">
                <br>
                <h2> Active Subscriptions </h2>
            </div>
            <hr>

            
        <div class="all-subscriptions">
            
    
            <?php if (isset($subs) && is_array($subs)): ?>
            <table class="subscribers-table">
                <thead>
                <tr>
                   
                    <th>Account ID</th>
                    <th>Subscription ID</th>
                    <th>Current Period Start</th>
                    <th>Current Period End</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($subs as $subscriber): ?>
                    <tr>
                    <td><?= htmlspecialchars($subscriber->accountID) ?></td>
                    <td><?= htmlspecialchars($subscriber->stripe_subscription_id) ?></td>
                    <td><?= htmlspecialchars($subscriber->current_period_start) ?></td>
                    <td><?= htmlspecialchars($subscriber->current_period_end) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <p>No subscribers available.</p>
            <?php endif; ?>
        </div>
    </div>

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

<script>
    function deletePlan(planId) {
        if (confirm('Are you sure you want to delete this Plan?')) {
            fetch(`<?=ROOT?>/manager/deletePlan/${planId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(response => {
                if (response.ok) {
                    alert('Plan deleted successfully');
                    window.location.reload();
                } else {
                    alert('An error occurred');
                }
            });
        }
    }
</script>
