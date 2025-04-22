<link rel="stylesheet" href="<?= ROOT ?>/assets/css/user/report.css">

<style>
    .posted-job-section table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
  
    .posted-job-section table th, table td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }
  
    .posted-job-section table th {
      background-color: #f2f2f2;
      font-weight: bold;
    }
  
    .posted-job-section table tr:nth-child(even) {
      background-color: #f9f9f9;
    }
  
    .posted-job-section table tr:hover {
      background-color: #f1f1f1;
    }
  
    .report-section {
      margin-bottom: 20px;
    }
  
    .report-section h4 {
      font-size: 18px;
      margin-bottom: 10px;
    }
  
    .posted-jobs-section p {
      margin-bottom: 10px;
    }
</style>
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
                        <p>Name: <?= htmlspecialchars($profile[0]->fname ?? '') . " " . htmlspecialchars($profile[0]->lname ?? ''); ?></p>
                        <p>Account ID: <?= htmlspecialchars($profile[0]->accountID ?? ''); ?></p>
                        <p>Email: <?= htmlspecialchars($profile[0]->email ?? ''); ?></p>
                        <p>Plan: <?= htmlspecialchars($profile[0]->planName ?? ''); ?></p>
                    </div>
                    <hr>
                    <div class="report-section">
                        <h4>Task Statistics</h4><br>
                        <div class="posted-jobs-section">
                        <p>Posted Jobs: <?= htmlspecialchars($postedJobs['count']) ?></p>
                        
                        <?php if (!empty($postedJobs['jobs'])): ?>
                            <table>
                                <thead>
                                    <tr>
                                        <!-- <th>Job ID</th> -->
                                        <th>Job Title</th>
                                        <th>Date Posted</th>
                                        <th>Description</th>
                                        <th>Location</th>
                                        <th>Applicants</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($postedJobs['jobs'] as $job): ?>
                                        <tr>
                                            <!-- <td><?= htmlspecialchars($job->jobID) ?></td> -->
                                            <td><?= htmlspecialchars($job->jobTitle) ?></td>
                                            <td><?= date('M d, Y', strtotime($job->datePosted)) ?></td>
                                            <td><?= htmlspecialchars($job->description) ?></td>
                                            <td><?= htmlspecialchars($job->location) ?></td>
                                            <td><?= htmlspecialchars($job->noOfApplicants) ?> </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p>No jobs posted yet.</p>
                        <?php endif; ?>
                          
                    </div>
                        <p>Tasks Completed:</p>
                        <div class="applied-job-section">
                            <p>Total Applications: <?= htmlspecialchars(count($appliedJobs['jobs'] ?? [])) ?></p>

                            <?php if (!empty($appliedJobs['jobs'])): ?>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Job Name</th>
                                            <th>Date Applied</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($appliedJobs['jobs'] as $job): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($job->jobTitle ?? 'N/A') ?></td>
                                                <td><?= !empty($job->dateApplied) ? date('M d, Y', strtotime($job->dateApplied)) : 'N/A' ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <p>No applications found.</p>
                            <?php endif; ?>

                            <p>Rejected: <?= htmlspecialchars($rejectedCount ?? 0) ?></p>
                        </div>
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
