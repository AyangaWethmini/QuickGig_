<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php';
protectRoute([1]); ?>

<!-- Include custom CSS -->
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/manager/report.css">

<?php include APPROOT . '/views/components/navbar.php'; ?>

<div class="wrapper">
    <?php require APPROOT . '/views/manager/manager_sidebar.php'; ?>

    <div class="main-content" style="overflow-y: auto; max-height: 100vh;">

        <div id="print-area">
            <!-- Print header -->
            <div class="print-header container flex-row">
                <div class="header-img">
                    <img src="<?= ROOT ?>/assets/images/QuickGiglLogo.png" alt="Logo" height="40">
                </div>
                <div class="heading">
                    <p><strong>User Report</strong></p>
                </div>
            </div>

            <!-- Report content -->
            <div id="report-content">

                <div>
                    <div class="report-section">
                        <h4>Profile Summary</h4><br>
                        <p>Name: </p>
                        <p>Account ID:</p>
                        <p>Email:</p>
                        <p>Plan:</p>
                    </div>
                    <hr>
                    <div class="report-section">
                        <h4>Task Statistics</h4><br>
                        <p>Tasks Posted:</p>
                        <p>Tasks Completed:</p>
                        <p>Applied:</p>
                        <p>Accepted:</p>
                        <p>Rejected:</p>
                    </div>
                    <hr>
                    <div class="report-section">
                        <h4>Payment Statistics</h4><br>
                        <p>Total Earnings:</p>
                        <p>Total Spent:</p>
                        <p>Pending Payments:</p>
                        <p>History:</p>
                    </div>
                    <hr>
                    <div class="report-section">
                        <h4>Performance</h4><br>
                        <p>Rating:</p>
                        <p>No. of Reviews:</p>
                        <p>Reports:</p>
                        <p>Complaints:</p>
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
</div>

<script>
    function printDiv() {
        window.print();
    }
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>
