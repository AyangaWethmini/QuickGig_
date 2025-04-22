<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php';
protectRoute([1]); ?>

<style>
.wrapper {
  margin-top: 100px;
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

.report-table {
  width: 90%;
  border-collapse: collapse;
  margin: 20px 0;
  font-size: 16px;
  text-align: left;
}

.report-table thead th {
  background-color: #f4f4f4;
  color: #333;
  font-weight: bold;
  padding: 10px;
  border: 1px solid #ddd;
}

.report-table tbody td {
  padding: 10px;
  border: 1px solid #ddd;
}

.report-table tfoot td {
  font-weight: bold;
  background-color: #f4f4f4;
  padding: 10px;
  border: 1px solid #ddd;
  text-align: right;
}

.header {
  margin: 20px;
  padding: 10px;
}

.header h2 {
  color: var(--Neutrals-100, #25324B);
  font-family: Epilogue;
  font-size: 32px;
  font-style: normal;
  font-weight: 600;
  line-height: 120%;
}

/* Hide print header and footer on screen */
.print-header,
.print-footer {
  display: none;
}

@media print {
  /* Create a print-only container that won't affect screen layout */
  body.printing {
    margin: 0;
    padding: 0;
    visibility: hidden;
  }
  
  body.printing #print-area {
    visibility: visible;
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: auto;
    margin: 0;
    padding: 0;
    background: white;
    z-index: 9999;
  }

  /* Print header styling */
  .print-header {
    display: flex;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    padding: 10mm 10mm 5mm 10mm;
    border-bottom: 1px solid #ccc;
    background: white;
    align-items: center;
    justify-content: space-between;
  }

  .print-footer {
    display: block;
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 5mm 10mm;
    border-top: 1px solid #ccc;
    background: white;
    text-align: center;
    font-size: 10pt;
  }

  /* Adjust report content to avoid header/footer */
  #report-content {
    margin-top: 25mm;  /* Space for header */
    margin-bottom: 15mm; /* Space for footer */
    padding: 0 10mm;
  }

  /* Table styling for print */
  .report-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 10pt;
    page-break-inside: avoid;
    margin: 5mm 0;
  }

  .report-table th, 
  .report-table td {
    border: 1px solid #ddd;
    padding: 4pt;
  }

  /* Prevent page breaks inside important elements */
  h3, tr {
    page-break-inside: avoid;
  }

  /* Add some space before headings */
  h3 {
    margin-top: 15px;
    margin-bottom: 10px;
    page-break-after: avoid;
  }

  /* Hide non-print elements */
  .no-print {
    display: none !important;
  }
  
  /* Ensure tables don't overflow */
  table {
    width: 100% !important;
    max-width: 100% !important;
  }
  
  /* Force page breaks between sections */
  .revenue > div {
    page-break-inside: avoid;
    margin-bottom: 10mm;
  }
}
</style>



<!-- Include custom CSS -->
<!-- <link rel="stylesheet" href="<?= ROOT ?>/assets/css/manager/mgr_report.css"> -->

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
                <div class="header-top">
                <div class="header-img">
                    <img src="<?= ROOT ?>/assets/images/QuickGiglLogo.png" alt="Logo" height="40">
                </div>
                <div class="heading">
                    <p><strong>System Report</strong></p>
                </div>
                </div>
            </div>


            <!-- Report content -->
            <div id="report-content">
                <div class="revenue">
                    <div class="revenue">
                        <table class="report-table">
                            <caption><h3>Subscription Revenue</h3></caption>
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
                    </div><br>
                    <div class="revenue">
                        
                        <table class="report-table">
                        <caption><h3>Advertisement Revenue</h3></caption>
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
                        <br>
                        <table class="report-table">
                        <caption><h3>User Stats</h3></caption>
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
                    <!-- <div>
                        <h3>Tasks</h3>
                        <p>Posted: </p>
                        <p>Completed : </p>
                    </div> -->
                </div>
                    
            </div>
            
            <!-- Print footer -->
            <div class="print-footer">
                Generated on <?= date("Y-m-d H:i"); ?>
            </div>
        </div>

    
        

        <!-- Print button -->
        <button class="no-print btn btn-accent" onclick="printDiv()">Print Report</button>
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
        // Add printing class to body without changing visible content
        document.body.classList.add('printing');
        
        // Open print dialog
        window.print();
        
        // Remove printing class after a short delay
        setTimeout(function() {
            document.body.classList.remove('printing');
        }, 500);
    }
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>