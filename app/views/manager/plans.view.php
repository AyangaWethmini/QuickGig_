<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php';
protectRoute([1]); ?>

<?php include APPROOT . '/views/components/deleteConfirmation.php'; ?>
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/manager/plan.css">
<?php include APPROOT . '/views/components/navbar.php'; ?>

<div class="wrapper flex-row" style="margin-top: 100px;">
    <?php require APPROOT . '/views/manager/manager_sidebar.php'; ?>

    <div class="main-content">
        <div class="plans-section">
            <!-- Header Section -->
            <div class="plan-header flex-row">
                <br>
                <h2>Subscription Plans</h2>
            </div>
            <hr>

            <div class="plans container flex-row">
                <!-- Create Plan Form Section -->
                <div class="plan-form container">
                    <form action="<?= ROOT ?>/manager/createPlan" method="POST" id="createPlanForm">
                        <h3>Create a new subscription plan</h3>

                        <div class="form-field">
                            <label for="planName">
                                <p class="lbl">Plan Name</p>
                            </label>
                            <input type="text" id="planName" name="planName" placeholder="Plan Name" maxlength="20" required>
                        </div>

                        <div class="form-field">
                            <label for="price">
                                <p class="lbl">Price</p>
                            </label>
                            <input type="number" id="price" name="price" placeholder="Price" step="0.01" required>
                        </div>

                        <div class="form-field">
                            <label for="posts">
                                <p class="lbl">Number of posts</p>
                            </label>
                            <input type="number" id="posts" name="postLimit" placeholder="Number of posts" required>
                        </div>

                        <div class="form-field">
                            <label for="duration">
                                <p class="lbl">Duration (in months)</p>
                            </label>
                            <input type="number" id="duration" name="duration" placeholder="Duration" required>
                        </div>

                        <div class="form-field">
                            <label for="description">
                                <p class="lbl">Description</p>
                            </label>
                            <textarea id="description" name="description" placeholder="Description" maxlength="1000" required></textarea>
                        </div>

                        <div class="form-field">
                            <label for="stripe_price_id">
                                <p class="lbl">Stripe Price ID</p>
                            </label>
                            <input type="text" id="stripe_price_id" name="stripe_price_id" placeholder="Stripe Price ID">
                        </div>

                        <div class="form-field">
                            <label for="currency">
                                <p class="lbl">Currency</p>
                            </label>
                            <select id="currency" name="currency" required>
                                <option value="LKR" selected>LKR (Sri Lankan Rupee)</option>
                                <option value="USD">USD (US Dollar)</option>
                                <option value="EUR">EUR (Euro)</option>
                            </select>
                        </div>

                        <div class="form-field">
                            <label for="recInterval">
                                <p class="lbl">Recurring Interval</p>
                            </label>
                            <select id="recInterval" name="recInterval" required>
                                <option value="monthly" selected>Monthly</option>
                                <option value="yearly">Yearly</option>
                                <option value="weekly">Weekly</option>
                                <option value="daily">Daily</option>
                            </select>
                        </div>

                        <div class="form-field flex-row" style="gap: 10px; align-items: left;">
                            <input type="checkbox" id="badge" name="badge" value="1">
                            <label for="badge">
                                <p class="lbl">Verified Badge</p>
                            </label>
                        </div>

                        <div class="form-field flex-row" style="gap: 10px; align-items: left;">
                            <input type="checkbox" id="active" name="active" value="1" checked>
                            <label for="active">
                                <p class="lbl">Active Plan</p>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-accent" name="createPlan">Create Plan</button>
                    </form>
                </div>

                <!-- Display Plans Section -->
                <div class="all-plans flex-col container">
                    <?php if (is_array($plans) || is_object($plans)): ?>
                        <?php foreach ($plans as $plan): ?>
                            <div class="plan-card">
                                <div class="subscription-plan-name"><?= htmlspecialchars($plan->planName) ?></div>
                                <div class="subscription-plan-price"><?= htmlspecialchars($plan->price) . htmlspecialchars($plan->currency) ?>/Month</div>
                                <ul class="subscription-plan-options">
                                    <li><?= $plan->badge ? 'Verified Badge' : 'No Verified Badge' ?></li>
                                    <li><?= htmlspecialchars($plan->postLimit) ?> Posts per month</li>
                                    <li><?= htmlspecialchars($plan->description) ?></li>
                                    <li>Duration: <?= htmlspecialchars($plan->duration) ?> months</li>
                                </ul>
                                <div class="sub-btns flex-row" style="gap: 30px;">
                                    <button class="btn btn-accent" onclick="window.location.href='<?= ROOT ?>/manager/updatePlanForm/<?= $plan->planID ?>'">Edit Plan</button>
                                    <button class="btn btn-del" onclick="showConfirmation('Are you sure you want to delete the Plan?', 
                                () => submitForm('<?= ROOT ?>/manager/deletePlan/<?= htmlspecialchars($plan->planID) ?>'))">Delete Plan</button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No plans available.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <br>
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
    // function deletePlan(planId) {
    //     if (confirm('Are you sure you want to delete this Plan?')) {
    //         fetch(`<?= ROOT ?>/manager/deletePlan/${planId}`, {
    //             method: 'POST',
    //             headers: {
    //                 'Content-Type': 'application/json',
    //             }
    //         })
    //         .then(response => {
    //             if (response.ok) {
    //                 alert('Plan deleted successfully');
    //                 window.location.reload();
    //             } else {
    //                 alert('An error occurred');
    //             }
    //         });
    //     }
    // }



    //frontend validation 
    document.getElementById('createPlanForm').addEventListener('submit', function(e) {
        const planName = document.getElementById('planName').value.trim();
        const price = document.getElementById('price').value.trim();
        const posts = document.getElementById('posts').value.trim();
        const duration = document.getElementById('duration').value.trim();
        const description = document.getElementById('description').value.trim();
        const stripePriceId = document.getElementById('stripe_price_id').value.trim();

        // Validate Plan Name
        if (planName === '' || planName.length > 20) {
            alert('Plan Name is required and must not exceed 20 characters.');
            e.preventDefault();
            return;
        }

        // Validate Price
        if (price === '' || isNaN(price) || parseFloat(price) <= 0) {
            alert('Price is required and must be a positive number.');
            e.preventDefault();
            return;
        }

        // Validate Number of Posts
        if (posts === '' || isNaN(posts) || parseInt(posts) <= 0) {
            alert('Number of posts is required and must be a positive integer.');
            e.preventDefault();
            return;
        }

        // Validate Duration
        if (duration === '' || isNaN(duration) || parseInt(duration) <= 0) {
            alert('Duration is required and must be a positive integer.');
            e.preventDefault();
            return;
        }

        // Validate Description
        if (description === '' || description.length > 1000) {
            alert('Description is required and must not exceed 1000 characters.');
            e.preventDefault();
            return;
        }

        // Validate Stripe Price ID (optional)
        if (stripePriceId !== '' && (stripePriceId.length > 50 || !/^price_[a-zA-Z0-9]+$/.test(stripePriceId))) {
            alert('Stripe Price ID must not exceed 50 characters and must match the format "price_xxxxxxxx".');
            e.preventDefault();
            return;
        }
    });
</script>