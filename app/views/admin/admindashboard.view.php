<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php';
protectRoute([0]); ?>
<link rel="stylesheet" href="<?php echo ROOT; ?>/assets/css/admin/admin_dashboard.css">
<?php include APPROOT . '/views/components/navbar.php'; ?>

<div class="admin-layout">
    <?php require APPROOT . '/views/components/admin_sidebar.php'; ?>
    <div class="admin-container">
        <div class="admin-announcement-header">
            <h1>Dashboard Overview</h1>
        </div>
        <hr>
        <div class="admin-dashboard">
            <div class="dashboard-card">
                <div class="card-icon">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="card-content">
                    <h2>Total Job Seekers</h2>
                    <p><?php echo $data['totalIndividuals']; ?></p>
                </div>
            </div>
            <div class="dashboard-card">
                <div class="card-icon">
                    <i class="fas fa-building"></i>
                </div>
                <div class="card-content">
                    <h2>Total Organizations</h2>
                    <p><?php echo $data['totalOrganizations']; ?></p>
                </div>
            </div>
            <div class="dashboard-card">
                <div class="card-icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <div class="card-content">
                    <h2>Total Jobs Posted</h2>
                    <p><?php echo $data['totalJobs']; ?></p>
                </div>
            </div>
            <div class="dashboard-card">
                <div class="card-icon">
                    <i class="fas fa-bullhorn"></i>
                </div>
                <div class="card-content">
                    <h2>Total Announcements</h2>
                    <p><?php echo $data['totalAnnouncements']; ?></p>
                </div>
            </div>
            <div class="dashboard-card">
                <div class="card-icon">
                    <i class="fas fa-ad"></i>
                </div>
                <div class="card-content">
                    <h2>Total Advertisements</h2>
                    <p><?php echo $data['totalAds']; ?></p>
                </div>
            </div>
            <div class="dashboard-card">
                <div class="card-icon">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <div class="card-content">
                    <h2>Total Complaints</h2>
                    <p><?php echo $data['totalComplaints']; ?></p>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="charts-section">
            <div class="chart-container">
                <h3>User Distribution</h3>
                <canvas id="userChart"></canvas>
            </div>
            <div class="chart-container">
                <h3>Platform Activity</h3>
                <canvas id="activityChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Add Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<!-- Add Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // User Distribution Chart
    const userCtx = document.getElementById('userChart').getContext('2d');
    new Chart(userCtx, {
        type: 'doughnut',
        data: {
            labels: ['Job Seekers', 'Organizations'],
            datasets: [{
                data: [<?php echo $data['totalIndividuals']; ?>, <?php echo $data['totalOrganizations']; ?>],
                backgroundColor: ['#ad73f5', '#7389f5'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Activity Chart
    const activityCtx = document.getElementById('activityChart').getContext('2d');
    new Chart(activityCtx, {
        type: 'bar',
        data: {
            labels: ['Jobs', 'Announcements', 'Advertisements', 'Complaints'],
            datasets: [{
                data: [
                    <?php echo $data['totalJobs']; ?>,
                    <?php echo $data['totalAnnouncements']; ?>,
                    <?php echo $data['totalAds']; ?>,
                    <?php echo $data['totalComplaints']; ?>
                ],
                backgroundColor: ['#7389f5', '#ad73f5', '#73f5e5', '#f573aa'],
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>