<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([1]); ?>
<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/manager.css">
<!-- <link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/dashboard.css"> -->
<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/manager_commons.css">

<!-- Chart.js CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

<?php include APPROOT . '/views/components/navbar.php'; ?>

<div class="wrapper flex-row" style="margin-top: 100px;">
    <?php require APPROOT . '/views/manager/manager_sidebar.php'; ?>

    <div class="main-content container">
        <div class="header flex-row">
            <span class="greeting container">
                <h3>Hello <?= htmlspecialchars($mgrName->fname); ?>! </h3>
                <p class="text-grey">Here is the statistics from <?= date('jS F', strtotime('first day of this month')); ?> - <?= date('jS F'); ?></p>
            </span>

            <form id="dateRangeForm" action="<?=ROOT?>/manager/index" method="POST" class="date-range-form flex-row">
                <span class="date">
                    <div class="date-selector" onclick="openModal()">
                        <span id="dateRange" class="date-text"><?= date('jS M', strtotime('first day of this month')) . ' – ' . date('jS M'); ?></span>
                        <i class="fas fa-calendar-alt calendar-icon"></i>
                    </div>

                    <!-- Date range modal -->
                    <div id="dateModal" class="modal">
                        <div class="modal-content">
                            <h3>Select Date Range</h3>
                            <input type="date" id="startDate" name="startDate" placeholder="Start Date" value="<?= date('Y-m-01'); ?>" />
                            <input type="date" id="endDate" name="endDate" placeholder="End Date" value="<?= date('Y-m-d'); ?>" />
                            
                            <div class="modal-buttons">
                                <button type="button" class="cancel-btn" onclick="closeModal()">Cancel</button>
                                <button type="submit" class="apply-btn">Apply</button>
                            </div>
                        </div>
                    </div>
                </span>
            </form>
        </div>

        
        <div class="overview flex-row">
    <div class="box container" style="background-color: var(--brand-primary);">
        <h3><?= htmlspecialchars($adCount); ?> Ads Posted</h3>
    </div>
    
    <div class="box container" style="background-color: #56CDAD;">
        <h3><?= htmlspecialchars($subCount); ?> Subscribers</h3>
    </div>
    
    <div class="box container" style="background-color: #26A4FF;">
        <h3><?= htmlspecialchars($planCount); ?> Active Plans</h3>
    </div>
    
    <div class="box container" style="background-color: #FFB836;">
        <h3><?= htmlspecialchars($revenue['totalRevenue']) + htmlspecialchars($revenue['totalEarnings']); ?> lkr Revenue</h3>
    </div>
</div>



        <hr><br>
        <div class="manager-sections flex-row">
            <div class="chart-overview container flex-row">
                <h3>Ad metrics</h3>
                <canvas id="ads-chart"></canvas>
            </div>

            <div class="chart-overview container flex-row">
                <h3>Revenue metrics</h3>
                <canvas id="revenue-chart"></canvas>
            </div>

            <div class="chart-overview container flex-row">
                <h3>Subscriptions metrics - Active Currently</h3>
                <canvas id="subscriptions-chart"></canvas>
            </div>
        </div>

                <!-- <?php if (isset($_SESSION['email'])): ?>
                    <a href="mailto:<?= htmlspecialchars($_SESSION['email']); ?>" class="email">Check Emails</a>
                <?php else: ?>
                    <a href="https://mail.google.com/" class="email">Check Emails</a>
                <?php endif; ?> -->
            </div>
        </div>

        <!-- <div class="section-revenue">
            <div class="chart-overview container flex-row">
                <canvas id="rev-chart" style="width: 700px; max-width:700px"></canvas>
            </div>
        </div> -->

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
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
    // Modal functionality
    const dateModal = document.getElementById('dateModal');
    const dateRangeDisplay = document.getElementById('dateRange');

    function openModal() {
        dateModal.style.display = 'flex';
    }

    function closeModal() {
        dateModal.style.display = 'none';
    }

    

    // Bar chart for clicks and views
    document.addEventListener("DOMContentLoaded", function () {
    renderAdMetricsChart();
    renderRevenueChart();
    renderSubscriptionChart();
});

function renderAdMetricsChart() {
    const ctx = document.getElementById('ads-chart');
    if (!ctx) return;

    new Chart(ctx.getContext('2d'), {
        type: 'bar',
        data: {
            labels: ['Views', 'Clicks'],
            datasets: [{
                label: 'Ad Metrics',
                data: [<?= htmlspecialchars($adViews); ?>, <?= htmlspecialchars($adClicks); ?>],
                backgroundColor: ['rgba(54, 162, 235)', 'rgba(255, 99, 132)'],
                borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: {
                    display: true,
                    text: 'Ad Views and Clicks'
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Metrics'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Count'
                    }
                }
            }
        }
    });
}

function renderRevenueChart() {
    const ctx = document.getElementById('revenue-chart');
    if (!ctx) return;

    new Chart(ctx.getContext('2d'), {
        type: 'pie',
        data: {
            labels: ['Subscriptions', 'Advertisements'],
            datasets: [{
            data: [<?= htmlspecialchars($revenue['totalEarnings']); ?>, <?= htmlspecialchars($revenue['totalRevenue']); ?>],
            backgroundColor: ['rgba(75, 192, 192)', 'rgba(255, 159, 64)'],
            borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 159, 64, 1)'],
            borderWidth: 1
            }]
        },
        plugins: {
            datalabels: {
                color: '#fff',
                anchor: 'end',
                align: 'start',
                formatter: (value) => `$${value}`
            }
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                title: {
                    display: true,
                    text: 'Revenue Breakdown'
                }
            }
        }
    });
}

function renderSubscriptionChart() {
    const ctx = document.getElementById('subscriptions-chart');
    if (!ctx) return;

    const subscriptionData = <?= json_encode($subscriptionData); ?>;
    const planNames = subscriptionData.map(item => item.planName);
    const subscriptionCounts = subscriptionData.map(item => item.subscriptionCount);

    new Chart(ctx.getContext('2d'), {
        type: 'bar',
        data: {
            labels: planNames,
            datasets: [{
                label: 'Subscription Counts',
                data: subscriptionCounts,
                backgroundColor: 'rgba(75, 192, 192)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: {
                    display: true,
                    text: 'Subscription Counts by Plan'
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Metrics'
                    }
                },
                y: {
                    suggestedMin: 0, // Ensures the y-axis starts at 0
                    title: {
                        display: true,
                        text: 'Count'
                    }
                }
            }
        }
    });
}
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>
