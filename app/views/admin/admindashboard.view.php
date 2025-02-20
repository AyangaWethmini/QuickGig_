<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([0]);?>
<link rel="stylesheet" href="<?php echo ROOT; ?>/assets/css/admin/admin_dashboard.css">
<?php include APPROOT . '/views/components/navbar.php'; ?>

<div class="admin-layout">
    <?php require APPROOT . '/views/components/admin_sidebar.php'; ?>
    <div class="admin-container">
        <div class="admin-announcement-header">
            <h1>Dashboard</h1>
        </div>
        <br>
        <hr><br>
        <div class="admin-dashboard">
            <div class="dashboard-card">
                <h2>Total Job Seekers</h2>
                <p><?php echo $data['totalIndividuals']; ?></p>
            </div>
            <div class="dashboard-card">
                <h2>Total Organizations</h2>
                <p><?php echo $data['totalOrganizations']; ?></p>
            </div>
            <div class="dashboard-card">
                <h2>Total Jobs Posted</h2>
                <p>456</p> <!-- Replace this with dynamic data if needed -->
            </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>