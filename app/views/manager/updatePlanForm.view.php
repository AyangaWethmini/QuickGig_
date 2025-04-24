<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([1]);?>
<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/plan.css"> 
<?php include APPROOT . '/views/components/navbar.php'; ?>

<div class="wrapper flex-row" style="margin-top: 100px;">
    <?php require APPROOT . '/views/manager/manager_sidebar.php'; ?>
    
    <div class="main-content">
        <!-- Header Section -->
        <div class="plan-header flex-row">
            <br>
            <h2>Update Subscription Plan</h2>
        </div>
        <hr>

        <div class="plan-form update-plan-form container">
            <form action="<?=ROOT?>/manager/updatePlan/<?= $plan->planID ?>" method="POST" id="updatePlanForm">
                
                <div class="form-field">
                    <label for="planName"><p class="lbl">Plan Name</p></label>
                    <input type="text" id="planName" name="planName" value="<?= htmlspecialchars($plan->planName) ?>" maxlength="20" required>
                </div>
                
                <div class="form-field">
                    <label for="price"><p class="lbl">Price</p></label>
                    <input type="number" id="price" name="price" value="<?= htmlspecialchars($plan->price) ?>" step="0.01" required>
                </div>
                
                <div class="form-field">
                    <label for="posts"><p class="lbl">Number of posts</p></label>
                    <input type="number" id="posts" name="postLimit" value="<?= htmlspecialchars($plan->postLimit) ?>" required>
                </div>
                
                <div class="form-field">
                    <label for="duration"><p class="lbl">Duration (in months)</p></label>
                    <input type="number" id="duration" name="duration" value="<?= htmlspecialchars($plan->duration) ?>" required>
                </div>
                
                <div class="form-field">
                    <label for="description"><p class="lbl">Description</p></label>
                    <textarea id="description" name="description" maxlength="1000" required><?= htmlspecialchars($plan->description) ?></textarea>
                </div>
                
                <div class="form-field">
                    <label for="stripe_price_id"><p class="lbl">Stripe Price ID</p></label>
                    <input type="text" id="stripe_price_id" name="stripe_price_id" value="<?= htmlspecialchars($plan->stripe_price_id) ?>">
                </div>
                
                <div class="form-field">
                    <label for="currency"><p class="lbl">Currency</p></label>
                    <select id="currency" name="currency" required>
                        <option value="LKR" <?= $plan->currency == 'LKR' ? 'selected' : '' ?>>LKR (Sri Lankan Rupee)</option>
                        <option value="USD" <?= $plan->currency == 'USD' ? 'selected' : '' ?>>USD (US Dollar)</option>
                        <option value="EUR" <?= $plan->currency == 'EUR' ? 'selected' : '' ?>>EUR (Euro)</option>
                    </select>
                </div>
                
                <div class="form-field">
                    <label for="recInterval"><p class="lbl">Recurring Interval</p></label>
                    <select id="recInterval" name="recInterval" required>
                        <option value="monthly" <?= $plan->recInterval == 'monthly' ? 'selected' : '' ?>>Monthly</option>
                        <option value="yearly" <?= $plan->recInterval == 'yearly' ? 'selected' : '' ?>>Yearly</option>
                        <option value="weekly" <?= $plan->recInterval == 'weekly' ? 'selected' : '' ?>>Weekly</option>
                        <option value="daily" <?= $plan->recInterval == 'daily' ? 'selected' : '' ?>>Daily</option>
                    </select>
                </div>

                <div class="form-field flex-row" style="gap: 10px; align-items: left;">
                    <input type="checkbox" id="badge" name="badge" value="1" <?= $plan->badge ? 'checked' : '' ?>>
                    <label for="badge"><p class="lbl">Verified Badge</p></label>
                </div>
                
                <div class="form-field flex-row" style="gap: 10px; align-items: left;">
                    <input type="checkbox" id="active" name="active" value="1" <?= $plan->active ? 'checked' : '' ?>>
                    <label for="active"><p class="lbl">Active Plan</p></label>
                </div>
                
                <button type="submit" class="btn btn-accent" name="updatePlan">Update Plan</button>
            </form>
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
