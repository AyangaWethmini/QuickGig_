<style>
    * {
        box-sizing: border-box;
    }

    .wrapper {
        margin-top: 80px;
        display: flex;
        width: 100%;
        min-height: 100vh;
        overflow: hidden;
    }

    .main-content {
        margin-left: 300px;
        flex: 1;
        padding: 20px;
    }


    .print-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px solid #ddd;
        padding: 10px 0;
        margin-bottom: 20px;
    }

    .print-header img {
        height: 40px;
    }

    .heading p {
        font-size: 18px;
        font-weight: bold;
        margin: 0;
    }

  
    .print-footer {
        text-align: center;
        margin-top: 40px;
        font-size: 12px;
        color: #777;
    }

 
    .report-table,
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        font-size: 14px;
    }

    .report-table th,
    .report-table td,
    table th,
    table td {
        padding: 10px;
        border: 1px solid #ccc;
        text-align: left;
    }

    .report-table thead {
        background-color: #f0f0f0;
        font-weight: bold;
    }

  
    .report-section h4 {
        margin-top: 20px;
        font-size: 18px;
        font-weight: 600;
        color: #333;
    }

 
    @media print {
        body {
            margin: 0;
            padding: 0;
            font-size: 12pt;
            color: #000;
            background: #fff;
        }

        body * {
            visibility: hidden;
        }

        #print-area,
        #print-area * {
            visibility: visible;
        }

        #print-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            padding: 0;
            margin: 0;
        }

        .print-header {
            display: flex;
            justify-content: space-between;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            padding: 10mm;
            border-bottom: 1px solid #ccc;
            background: white;
        }

        .print-footer {
            display: block;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 10mm;
            border-top: 1px solid #ccc;
            background: white;
            font-size: 10pt;
        }

        #report-content {
            margin-top: 30mm;
            margin-bottom: 20mm;
        }

        .report-table,
        table {
            font-size: 10pt;
            page-break-inside: auto;
        }

        .report-table th,
        .report-table td,
        table th,
        table td {
            padding: 6pt;
            border: 1px solid #999;
        }

        h4,
        tr,
        td,
        th {
            page-break-inside: avoid;
        }

        h4 {
            page-break-after: avoid;
        }

        .no-print {
            display: none !important;
        }
    }

    .report-section p {
        font-size: 16px;
        margin: 8px 0;
    }
</style>
<div class="wrapper">
    <div class="main-content" style="overflow-y: auto; max-height: 100vh;">
        <div id="print-area">
            
            <div class="print-header container flex-row">
                <div class="header-img">
                    <img src="<?= ROOT ?>/assets/images/QuickGiglLogo.png" alt="Logo" height="40">
                </div>
                <div class="heading">
                    <p><strong>User Report</strong></p>
                </div>
            </div>
            <br>

           
            <div id="report-content">
                <div>
                    <div class="report-section">
                        <h4>Profile Summary</h4><br>
                        <p>Name: <?= htmlspecialchars($profile[0]->fname ?? '') ?></p>
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
                        <p>Tasks Completed(From Applications):</p>
                        <div class="applied-job-section">
                            <!-- <p>Total Applications: <?= htmlspecialchars(count($appliedJobs['jobs'] ?? [])) ?></p> -->

                            <?php if (!empty($data['appliedJobs']) || !empty($data['appliedJobs1'])): ?>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Job Name</th>
                                            <th>Date Applied</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($data['appliedJobs'])): ?>
                                            <?php foreach ($data['appliedJobs'] as $job): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($job->jobTitle ?? 'N/A') ?></td>
                                                    <td><?= !empty($job->dateApplied) ? date('M d, Y', strtotime($job->dateApplied)) : 'N/A' ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                        <?php if (!empty($data['appliedJobs1'])): ?>
                                            <?php foreach ($data['appliedJobs1'] as $job): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($job->jobTitle ?? 'N/A') ?></td>
                                                    <td><?= !empty($job->dateApplied) ? date('M d, Y', strtotime($job->dateApplied)) : 'N/A' ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <p>No applications found.</p>
                            <?php endif; ?>

                            <!-- <p>Rejected: <?= htmlspecialchars($rejectedCount ?? 0) ?></p> -->
                        </div>

                        <p>Tasks Completed(From Requests):</p>
                        <div class="applied-job-section">
                            <!-- <p>Total Applications: <?= htmlspecialchars(count($appliedJobs['jobs'] ?? [])) ?></p> -->

                            <?php if (!empty($data['requestedJobs']) || !empty($data['requestedJobs1'])): ?>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Job Name</th>
                                            <th>Date Requested</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($data['requestedJobs'])): ?>
                                            <?php foreach ($data['requestedJobs'] as $job): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($job->description ?? 'N/A') ?></td>
                                                    <td><?= !empty($job->datePosted) ? date('M d, Y', strtotime($job->datePosted)) : 'N/A' ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                        <?php if (!empty($data['requestedJobs1'])): ?>
                                            <?php foreach ($data['requestedJobs1'] as $job): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($job->description ?? 'N/A') ?></td>
                                                    <td><?= !empty($job->datePosted) ? date('M d, Y', strtotime($job->datePosted)) : 'N/A' ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <p>No applications found.</p>
                            <?php endif; ?>

                            <!-- <p>Rejected: <?= htmlspecialchars($rejectedCount ?? 0) ?></p> -->
                        </div>
                    </div>
                    <hr>
                    
                    <div class="report-section">
                        <h4>Performance</h4><br>
                        <p>Rating: <?= htmlspecialchars($averageRating ?? 'N/A') ?></p>
                        <p>No. of Reviews Given: <?= htmlspecialchars($reviewsGivenCount ?? 0) ?></p>
                        <p>No. of Reviews Received: <?= htmlspecialchars($reviewsReceivedCount ?? 0) ?></p>
                        <p>Complaints Made: <?= htmlspecialchars($complaintsMadeCount ?? 0) ?></p>
                        <p>Complaints Received: <?= htmlspecialchars($complaintsReceivedCount ?? 0) ?></p>
                    </div>
                </div>
            </div>

            
            <div class="print-footer">
                Generated on <?= date("Y-m-d H:i"); ?>
            </div>
        </div>

       
        <button class="no-print btn btn-accent" onclick="printDiv()">Download Report</button>
    </div>
</div>

<script>
    function printDiv() {
        window.print();
    }
</script>