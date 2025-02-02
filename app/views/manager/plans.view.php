<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([1]);?>
<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/plan.css"> 
<?php include APPROOT . '/views/components/navbar.php'; ?>

<div class="wrapper flex-row" style="margin-top: 100px;">
    <?php require APPROOT . '/views/manager/manager_sidebar.php'; ?>
    
    <div class="main-content">
        <!-- Header Section -->
        <div class="header flex-row">
            <h3>Subscription Plans</h3>
        </div>
        <hr>

        <div class="plans container flex-row">
            <!-- Create Plan Form Section -->
            <div class="create-plan-form container">
                <form action="<?=ROOT?>/manager/createPlan" method="POST" id="createPlanForm">
                    <h3>Create a new subscription plan</h3>
                    
                    <div class="form-field">
                        <label for="planName"><p class="lbl">Plan Name</p></label>
                        <input type="text" id="planName" name="planName" placeholder="Plan Name">
                    </div>
                    <div class="form-field">
                        <label for="price"><p class="lbl">Price</p></label>
                        <input type="number" id="price" name="price" placeholder="Price" step="0.01">
                    </div>
                    <div class="form-field">
                        <label for="posts"><p class="lbl">Number of posts</p></label>
                        <input type="number" id="posts" name="postLimit" placeholder="Number of posts">
                    </div>
                    <div class="form-field">
                        <label for="duration"><p class="lbl">Duration</p></label>
                        <input type="number" id="duration" name="duration" placeholder="Duration">
                    </div>
                    <div class="form-field">
                        <label for="description"><p class="lbl">Description</p></label>
                        <input type="text" id="description" name="description" placeholder="Description">
                    </div>
                    <div class="form-field flex-row" style="gap: 10px; align-items: left;">
                        <input type="checkbox" id="badge" name="badge">
                        <label for="badge"><p class="lbl">Verified Badge</p></label>
                    </div>
                    <button type="submit" class="btn btn-accent" name="createPlan">Create Plan</button>
                </form>
            </div>

            <!-- Display Plans Section -->
            <div class="all-plans flex-col container">
                <?php 
                // This should be replaced with actual data from the backend
                $plans = [
                    ['name' => 'Basic', 'price' => '15.00'],
                    ['name' => 'Standard', 'price' => '25.00'],
                    ['name' => 'Pro', 'price' => '35.00'] 
                ];
                
                foreach ($plans as $plan): ?>
                    <div class="plan-card">
                        <div class="subscription-plan-name"><?= $plan['name'] ?></div>
                        <div class="subscription-plan-price">$<?= $plan['price'] ?>/Month</div>
                        <ul class="subscription-plan-options">
                            <li>Verified Badge</li>
                            <li>10 Posts per month</li>
                            <li>ztututu</li>
                            <li>bruh</li>
                        </ul>
                        <div class="sub-btns flex-row" style="gap: 30px;">
                            <button class="btn btn-accent">Edit Plan</button>
                            <button class="btn btn-del">Delete Plan</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>