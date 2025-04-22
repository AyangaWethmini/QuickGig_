<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php';
protectRoute([1]); ?>

<!-- Include custom CSS -->
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/manager/mgr_report.css">

<?php include APPROOT . '/views/components/navbar.php'; ?>

<div class="wrapper">
    <?php require APPROOT . '/views/manager/manager_sidebar.php'; ?>

    <div class="main-content" style="overflow-y: auto; max-height: 100vh;">
        <div class="header flex-col">
            <h2>System Report</h2>
            <hr>
        </div>

        <div id="print-area">
            <!-- Print header -->
            <div class="print-header container flex-row">
                <div class="header-img">
                    <img src="<?= ROOT ?>/assets/images/QuickGiglLogo.png" alt="Logo" height="40">
                </div>
                <div class="heading">
                    <p><strong>System Report</strong></p>
                </div>
            </div>

            <!-- Report content -->
            <div id="report-content">
                <div class="revenue">
                    <div class="revenue">
                        <h3>Subscription Revenue</h3>
                        <table class="report-table">
                            <thead>
                                <tr>
                                    <th>Plan ID</th>
                                    <th>Plan Name</th>
                                    <th>Price</th>
                                    <th>Duration</th>
                                    <th>Subscriptions</th>
                                    <th>Total Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($subEarnings as $plan): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($plan->planID) ?></td>
                                        <td><?= htmlspecialchars($plan->planName) ?></td>
                                        <td><?= htmlspecialchars($plan->price) ?></td>
                                        <td><?= htmlspecialchars($plan->duration) ?></td>
                                        <td><?= htmlspecialchars($plan->subscription_count) ?></td>
                                        <td><?= htmlspecialchars($plan->total_revenue) ?><?= htmlspecialchars($plan->currency);?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="revenue">
                        <h3>Advertisement Revenue</h3>
                        <table class="report-table">
                            <thead>
                                <tr>
                                    <th>Ad ID</th>
                                    <th>Title</th>
                                    <th>Days Active</th>
                                    <th>Weeks Active</th>
                                    <th>Revenue</th>
                                    <th>Paid Amount</th>
                                    <th>To Be Charged</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($adRevenue['ads'] as $ad): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($ad['adId']) ?></td>
                                        <td><?= htmlspecialchars($ad['title']) ?></td>
                                        <td><?= htmlspecialchars($ad['daysActive']) ?></td>
                                        <td><?= htmlspecialchars($ad['weeksActive']) ?></td>
                                        <td><?= htmlspecialchars($ad['revenue']) ?></td>
                                        <td><?= htmlspecialchars($ad['paidAmount']) ?></td>
                                        <td><?= htmlspecialchars($ad['toBeCharged']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4"><strong>Total Revenue</strong></td>
                                    <td colspan="3"><?= htmlspecialchars($adRevenue['totalRevenue']).'LKR' ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div>
                        <h3>Users</h3>
                        <table class="report-table">
                            <thead>
                                <tr>
                                    <th>Role</th>
                                    <th>Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $roles = [
                                    0 => 'Admin',
                                    1 => 'Manager',
                                    2 => 'Individual',
                                    3 => 'Organization'
                                ];
                                foreach ($userCount as $user): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($roles[$user->roleID]) ?></td>
                                        <td><?= htmlspecialchars($user->role_count) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <h3>Tasks</h3>
                        <p>Posted: </p>
                        <p>Completed : </p>
                    </div>
                </div>
                    
            </div>
            
            <!-- Print footer -->
            <div class="print-footer">
                Generated on <?= date("Y-m-d H:i"); ?>
            </div>
        </div>

    
        

        <!-- Print button -->
        <button class="no-print btn btn-accent" onclick="printDiv()">Download Report</button>
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
    function printDiv() {
        var printContents = document.getElementById('print-area').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    }
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>