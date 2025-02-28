<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/Components/jobProvider_sidebar.css">

<?php
function isActive($page)
{
    return strpos($_SERVER['REQUEST_URI'], $page) !== false ? 'active' : '';
}
?>

<body>

    <div class="sidebar-container">

        <div class="sidebar-items-container">
            <a href="<?php echo ROOT; ?>/admin/admindashboard" class="sidebar-item <?php echo isActive('admindashboard'); ?>">
                <span class="sidebar-icon"><i class="fa-solid fa-chart-line"></i></span>
                <span class="sidebar-label">Dashboard</span>
            </a>
            <br>

            <a href="<?php echo ROOT; ?>/admin/adminadvertisements" class="sidebar-item <?php echo isActive('adminadvertisements'); ?>">
                <span class="sidebar-icon"><i class="fa-solid fa-rectangle-ad"></i></span>
                <span class="sidebar-label">Advertisements</span>
            </a>
            <br>

            <a href="<?php echo ROOT; ?>/admin/adminannouncement" class="sidebar-item <?php echo isActive('adminannouncement'); ?>">
                <span class="sidebar-icon"><i class="fa-solid fa-bullhorn"></i></span>
                <span class="sidebar-label">Announcements</span>
            </a>
            <br>

            <a href="<?php echo ROOT; ?>/admin/admincomplaints" class="sidebar-item <?php echo isActive('admincomplaints'); ?>">
                <span class="sidebar-icon"><i class="fa-solid fa-list-check"></i></span>
                <span class="sidebar-label">Complaints</span>
            </a>
            <br>

            <a href="<?php echo ROOT; ?>/admin/adminmanageusers" class="sidebar-item <?php echo isActive('adminmanageusers'); ?>">
                <span class="sidebar-icon"><i class="fa-solid fa-user"></i></span>
                <span class="sidebar-label">Users</span>
            </a>

            <br>
        </div>

    </div>

</body>