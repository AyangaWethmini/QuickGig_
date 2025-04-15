<!--
    User Report Page
    This page generates a user report with sections for profile summary, task statistics, payment statistics, and performance.
    It includes a print button to download the report.  -->


<link rel="stylesheet" href="<?= ROOT ?>/assets/css/manager/report.css">



<div class="wrapper">
    

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
                        <!-- <table>
                            <thead>
                                <tr>
                                    <th>Job ID</th>
                                    <th>Job Title</th>
                                    <th>Date Posted</th>
                                    <th>Description</th>
                                    <th>Location</th>
                                    <th>No. of Applicants</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['postedJobs'] as $job): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($job['jobID']) ?></td>
                                        <td><?= htmlspecialchars($job['jobTitle']) ?></td>
                                        <td><?= htmlspecialchars($job['datePosted']) ?></td>
                                        <td><?= htmlspecialchars($job['description']) ?></td>
                                        <td><?= htmlspecialchars($job['location']) ?></td>
                                        <td><?= htmlspecialchars($job['noOfApplicants']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table> -->
                        <p>Tasks Completed: From where Can i Find this (din see in any tables)</p>
                        <p>Applied:</p>
                        <!-- <table>
                            <thead>
                                <tr>
                                    <th>Job Name</th>
                                    <th>Date Applied</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['appliedJobs'] as $job): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($job['jobname']) ?></td>
                                        <td><?= htmlspecialchars($job['dateApplied']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table> -->
                        <!-- <p>Accepted:</p>
                        <p>Rejected:</p> -->
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