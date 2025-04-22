<link href="<?=ROOT?>/assets/css/components/user_plan.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<div class="flex-row user-plan-container">
    <div class="main-content container flex-row user-plan-main">
        <div class="flex-col user-plan-column">

        <?php
            $currentController = explode('/', $_GET['url'])[0] ?? 'JobSeeker';
        ?>

            <div class="header container flex-row user-plan-header">
                <h3>My Subscription</h3><br>
            </div>

            <hr><br>

            <div class=" flex-row user-plan-dashboard">
                <div class="forum user-plan-forum">
                    <?php if (!empty($subscription) && is_array($subscription) && isset($subscription[0])): ?>
                        <?php $plan = $subscription[0]; ?>
                        <div class="article-card user-plan-card">
                            <h1 class="user-plan-title">Your Current Plan</h1>
                            <div class="plan-details user-plan-details">
                                <p><strong>Plan Name:</strong> <?php echo htmlspecialchars($plan->planName); ?></p>
                                <p><strong>Status:</strong> <span class="status-<?php echo strtolower($plan->status); ?>"><?php echo htmlspecialchars($plan->status); ?></span></p>
                                <p><strong>Start Date:</strong> <?php echo htmlspecialchars(date('F j, Y, g:i a', strtotime($plan->current_period_start))); ?></p>
                                <p><strong>End Date:</strong> <?php echo htmlspecialchars(date('F j, Y, g:i a', strtotime($plan->current_period_end))); ?></p>
                            </div>
                            <hr>
                            <div class="plan-actions flex-row user-plan-actions">
                            <?php if ($plan->status === 'active' || $plan->status === 'trialing'): ?>
                                <button class="btn btn-del user-plan-cancel">Cancel Subscription</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="article-card user-plan-card">
                            <h1 class="user-plan-title">No Active Subscription</h1>
                            <p class="text-grey text user-plan-text">
                                You don't have an active subscription. Subscribe to QuickGig Premium to unlock all features.
                            </p>
                            <hr>
                            <button class="btn btn-accent user-plan-discover" onclick="window.location.href='<?=ROOT?>/subscription/premium'">Discover Premium Plans</button>
                        </div>
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
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cancelBtn = document.querySelector('.user-plan-cancel');
    if (cancelBtn) {
        cancelBtn.addEventListener('click', function() {
            if (confirm('Are you sure you want to cancel your subscription? You will lose access to premium features at the end of your billing period.')) {
                // Get subscription ID from the page or make an AJAX call to get it
                fetch('<?=ROOT?>/subscription/cancel', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ confirm: true })
                })
                .then(response => {
                    if (response.redirected) {
                        window.location.href = response.url;
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        showAlert('Subscription cancelled successfully', 'success');
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    } else {
                        showAlert(data.error || 'Failed to cancel subscription', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('An error occurred', 'error');
                });
            }
        });
    }
});

</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>
