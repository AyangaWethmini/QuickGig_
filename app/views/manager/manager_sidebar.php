<link rel="stylesheet" href="<?=ROOT?>/assets/css/Components/manager_sidebar.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<?php
$current = $_SERVER['REQUEST_URI'];

// Advertisement section logic
$adsActive = strpos($current, '/manager/advertisements') !== false;
$advrsActive = strpos($current, '/manager/advertisers') !== false;
$isAdsParentActive = $adsActive || $advrsActive;

// Plans section logic
$plansActive = strpos($current, '/manager/plans') !== false;
$subsActive = strpos($current, '/manager/subscriptions') !== false;
$isPlansParentActive = $plansActive || $subsActive;
?>

<body>
    <div class="sidebar-container">
        <div class="sidebar-items-container">

            <a href="<?=ROOT?>/manager/profile" class="sidebar-item <?= strpos($current, '/manager/profile') !== false ? 'active' : '' ?>">
                <span class="sidebar-icon"><i class="fa-solid fa-user"></i></span>
                <span class="sidebar-label">Profile</span>
            </a>

            <a href="<?=ROOT?>/manager/dashboard" class="sidebar-item <?= strpos($current, '/manager/dashboard') !== false ? 'active' : '' ?>">
                <span class="sidebar-icon"><i class="fa-solid fa-chart-area"></i></span>
                <span class="sidebar-label">Dashboard</span>
            </a>

            <!-- Advertisement Section -->
            <div class="sidebar-item <?= $isAdsParentActive ? 'active-parent' : '' ?>" onclick="toggleSubMenu(this)">
                <span class="sidebar-icon"><i class="fa-solid fa-rectangle-ad"></i></span>
                <span class="sidebar-label">Advertisement</span>
            </div>
            <div class="sidebar-submenu" style="display: <?= $isAdsParentActive ? 'block' : 'none' ?>;">
                <a href="<?=ROOT?>/manager/advertisements" class="sidebar-item sub-item <?= $adsActive ? 'active' : '' ?>">
                    <span class="sidebar-label">Advertisements</span>
                </a>
                <a href="<?=ROOT?>/manager/advertisers" class="sidebar-item sub-item <?= $advrsActive ? 'active' : '' ?>">
                    <span class="sidebar-label">Advertisers</span>
                </a>
            </div>

            <!-- Plans Section -->
            <div class="sidebar-item <?= $isPlansParentActive ? 'active-parent' : '' ?>" onclick="toggleSubMenu(this)">
                <span class="sidebar-icon"><i class="fa-solid fa-certificate"></i></span>
                <span class="sidebar-label">Plan</span>
            </div>
            <div class="sidebar-submenu" style="display: <?= $isPlansParentActive ? 'block' : 'none' ?>;">
                <a href="<?=ROOT?>/manager/plans" class="sidebar-item sub-item <?= $plansActive ? 'active' : '' ?>">
                    <span class="sidebar-label">Plans</span>
                </a>
                <a href="<?=ROOT?>/manager/subscriptions" class="sidebar-item sub-item <?= $subsActive ? 'active' : '' ?>">
                    <span class="sidebar-label">Subscribers</span>
                </a>
            </div>

            <a href="<?=ROOT?>/manager/announcements" class="sidebar-item <?= strpos($current, '/manager/announcements') !== false ? 'active' : '' ?>">
                <span class="sidebar-icon"><i class="fa-solid fa-bullhorn"></i></span>
                <span class="sidebar-label">Announcements</span>
            </a>

            <a href="<?=ROOT?>/manager/report" class="sidebar-item <?= strpos($current, '/manager/report') !== false ? 'active' : '' ?>">
                <span class="sidebar-icon"><i class="fa-regular fa-chart-bar"></i></span>
                <span class="sidebar-label">Report</span>
            </a>

            <a href="<?=ROOT?>/manager/helpCenter" class="sidebar-item <?= strpos($current, '/manager/helpCenter') !== false ? 'active' : '' ?>">
                <span class="sidebar-icon"><i class="fa-solid fa-circle-question"></i></span>
                <span class="sidebar-label">Help Center</span>
            </a>

            <div class="sidebar-item" data-link="login-logout.php">
                <span class="sidebar-icon"><i class="fa-solid fa-power-off"></i></span>
                <span class="sidebar-label">Log Out</span>
            </div>

        </div>
    </div>

    <script>
        function toggleSubMenu(element) {
            const submenu = element.nextElementSibling;
            submenu.style.display = submenu.style.display === "block" ? "none" : "block";
        }
    </script>
</body>
