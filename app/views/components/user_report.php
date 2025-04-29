<style>
    * {
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .wrapper {
      margin-top: 80px;
      display: flex;
      width: 100%;
      min-height: 100vh;
    }

    .main-content {
      margin-left: 254px;
      flex: 1;
      padding: 30px;
      background: #fff;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      overflow-y: auto;
      max-height: 100vh;
    }

    .print-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 2px solid #eee;
      padding: 10px 0;
      margin-bottom: 30px;
    }

    .print-header img {
      height: 50px;
    }

    .heading p {
      font-size: 28px;
      font-weight: bold;
      margin: 0;
      color: #2c3e50;
    }

    .print-footer {
      text-align: center;
      margin-top: 40px;
      font-size: 14px;
      color: #777;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      font-size: 15px;
      background: #fff;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    table th, table td {
      padding: 14px 16px;
      border-bottom: 1px solid #eee;
      text-align: left;
    }

    table thead {
      background-color: rgba(98, 70, 234, 0.7);
      font-weight: bold;
      color: #fff;
    }

    table tr:hover {
      background-color: #f1f1f1;
    }

    .sub-head-report{
      font-size: 20px;
      font-weight: 600;
      color: #444;
      margin-top: 20px !important;
    }

    .report-section h4 {
      margin-top: 30px;
      font-size: 22px;
      font-weight: 700;
      color: #444;
      border-left: 4px solid var(--brand-primary);
      padding-left: 10px;
    }

    .report-section p {
      font-size: 17px;
      margin: 10px 0;
      color: #555;
      padding-left: 10px;
    }

    .report-section p strong {
      color: #333;
      font-weight: 600;
    }

    hr {
      margin: 30px 0;
      border: 0;
      border-top: 1px solid #eee;
    }

    .rpt-print {
      margin-top: 20px;
      background-color: var(--brand-primary);
      color: white;
      border: none;
      padding: 12px 24px;
      border-radius: 12px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .rpt-print:hover {
      background-color: #45a049;
    }

    @media print {
      body {
        margin: 0;
        padding: 0;
        font-size: 9pt; 
        color: #000;
        background: #fff;
      }

      body * {
        visibility: hidden;
      }

      #print-area, #print-area * {
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
        padding: 8mm;
        border-bottom: 1px solid #ccc;
        background: white;
      }

      .print-footer {
        display: block;
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 8mm;
        border-top: 1px solid #ccc;
        background: white;
        font-size: 9pt; 
      }

      #report-content {
        margin-top: 25mm;
        margin-bottom: 20mm;
      }

      table {
        font-size: 8pt;
        page-break-inside: auto;
      }

      table th, table td {
        padding: 4pt;
        border: 1px solid #999;
      }

      h4, tr, td, th {
        page-break-inside: avoid;
      }

      h4 {
        page-break-after: avoid;
        font-size: 12pt; 
      }

      p, span, div {
        font-size: 9pt;
      }

      .no-print {
        display: none !important;
      }
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
                        <p>Name: <?= htmlspecialchars($profile[0]->fname ?? '') . " " . htmlspecialchars($profile[0]->lname ?? ''); ?></p>
                        <p>Account ID: <?= htmlspecialchars($profile[0]->accountID ?? ''); ?></p>
                        <p>Email: <?= htmlspecialchars($profile[0]->email ?? ''); ?></p>
                        <p>Plan: <?= htmlspecialchars($profile[0]->planName ?? ''); ?></p>
                    </div>
                    <hr>
                    <div class="report-section">
                        <h4>Task Statistics</h4><br>
                        <div class="posted-jobs-section">
                        <p class="sub-head-report">Posted Jobs: <?= htmlspecialchars($postedJobs['count']) ?></p>
                        
                        <?php if (!empty($postedJobs['jobs'])): ?>
                            <table>
                                <thead>
                                    <tr>
                                        
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
                        <p class="sub-head-report">Tasks Completed(From Applications):</p>
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

                        <p class="sub-head-report">Tasks Completed(From Requests):</p>
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

    
        <button class="no-print btn btn-accent rpt-print" onclick="printDiv()">Download Report</button>
    </div>
</div>

<script>
    function printDiv() {
        window.print();
    }
</script>
