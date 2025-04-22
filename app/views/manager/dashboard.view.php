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
                <h3></h3>
                <p class="text-grey">Here is the statistics from <?= date('jS F', strtotime('-1 month')); ?> - <?= date('jS F'); ?></p>
            </span>

            <span class="date">
                <div class="date-selector" onclick="openModal()">
                    <span id="dateRange" class="date-text"><?= date('jS M', strtotime('-1 month')) . ' – ' . date('jS M'); ?></span>
                    <i class="fas fa-calendar-alt calendar-icon"></i>
                </div>

                <!-- Date range modal -->
                <div id="dateModal" class="modal">
                    <div class="modal-content">
                        <h3>Select Date Range</h3>
                        <form id="dateForm" onsubmit="applyDateRange(event)">
                            <input type="date" id="startDate" name="startDate" placeholder="Start Date" value="<?= date('Y-m-d', strtotime('-1 month')); ?>" />
                            <input type="date" id="endDate" name="endDate" placeholder="End Date" value="<?= date('Y-m-d'); ?>" />
                            
                            <div class="modal-buttons">
                                <button type="button" class="cancel-btn" onclick="closeModal()">Cancel</button>
                                <button type="submit" class="apply-btn">Apply</button>
                            </div>
                        </form>
                    </div>
                </div>
            </span>
        </div>

        <div class="overview flex-row">
            <div class="flex-row box container" style="background-color: var(--brand-primary);">
                <div><h3></h3></div>
            </div>
            <div class="flex-row box container" style="background-color: #56CDAD;">
                <div><h3></div>
            </div>
            <div class="flex-row box container" style="background-color: #26A4FF;">
                <div><h3></h3></div>
            </div>
            <div class="flex-row box container" style="background-color: #FFB836;">
                <div><h3></h3></div>
            </div>
        </div>

        <hr><br>

        <div class="manager-sections flex-row">
            <div class="chart-overview container flex-row">
                <canvas id="ads-chart" style="width:100%; max-width:700px"></canvas>
                <div class="count flex-col">
                    <div class="views">
                        <p class="title">Ads views</p>
                        <p class="number">2135</p>
                        <p class="grey-text">this week</p>
                    </div>
                    <div class="clicks">
                        <p class="ctitle">Ads clicks</p>
                        <p class="number">1500</p>
                        <p class="grey-text">this week</p>
                    </div>
                </div>
            </div>

            <div class="messages container flex-col">
                <p>All Requests</p>
                <p class="text-grey">Pending</p>
                <span class="requests">
                    <div class="request flex-row">
                        <img src="<?=ROOT?>/assets/images/profile.png" alt="profile pic">
                        <p class="name">John Doe</p><hr>
                    </div>
                    <div class="request flex-row">
                        <img src="<?=ROOT?>/assets/images/profile.png" alt="profile pic">
                        <p class="name">John Doe</p><hr>
                    </div>
                    <div class="request flex-row">
                        <img src="<?=ROOT?>/assets/images/profile.png" alt="profile pic">
                        <p class="name">John Doe</p><hr>
                    </div>
                </span>

                <?php if (isset($_SESSION['email'])): ?>
                    <a href="mailto:<?= htmlspecialchars($_SESSION['email']); ?>" class="email">Check Emails</a>
                <?php else: ?>
                    <a href="https://mail.google.com/" class="email">Check Emails</a>
                <?php endif; ?>
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

    // Apply date range and fetch updated stats
    function applyDateRange(event) {
    if (event) event.preventDefault();

    const startDate = document.getElementById("startDate").value;
    const endDate = document.getElementById("endDate").value;

    if (!startDate || !endDate) {
        console.log("Please select both start and end dates.");
        return;
    }

    const start = new Date(startDate);
    const end = new Date(endDate);
    const options = { day: 'numeric', month: 'short' };
    const fullOptions = { day: 'numeric', month: 'long' };

    dateRangeDisplay.innerText = `${start.toLocaleDateString('en-GB', options)} – ${end.toLocaleDateString('en-GB', options)}`;
    document.querySelector(".greeting p").innerText = `Here is the statistics from ${start.toLocaleDateString('en-GB', fullOptions)} - ${end.toLocaleDateString('en-GB', fullOptions)}`;

    // Send the date range to the server and fetch the updated data
    fetch('<?php echo ROOT; ?>/manager/getDashboardData', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            startDate: startDate,
            endDate: endDate
        })
    })
    .then(res => res.json())  // Parse the JSON response
    .then(data => {
        if (data.success) {
            // Update the frontend with the new data
            document.querySelector('.overview .box:nth-child(1) h3').innerText = `${data.adCount} Ads Posted`;
            document.querySelector('.overview .box:nth-child(2) h3').innerText = `${data.subsCount} Subscribers`;
            document.querySelector('.overview .box:nth-child(3) h3').innerText = `$${data.subRevenue} Revenue`;
            document.querySelector('.overview .box:nth-child(4) h3').innerText = `${data.planCount} Active Plans`;
            document.querySelector('.greeting h3').innerText = `Good morning! ${data.managerName}`;

            // Update the Chart
            const adsChart = Chart.getChart('ads-chart');
            if (adsChart) {
                adsChart.data.labels = data.chartLabels;  // You should be passing labels for the chart here
                adsChart.data.datasets[0].data = data.viewsData;  // Assuming you are passing these datasets from the backend
                adsChart.data.datasets[1].data = data.clicksData;
                adsChart.update();
            }
        } else {
            console.log('Failed to fetch data. Please try again.');
        }
    })
    .catch(err => {
        console.error('Error:', err);
        alert('An error occurred while fetching data.');
    });

    closeModal();
}


    // Line chart (ads views/clicks)
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('ads-chart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [
                    {
                        label: 'Views',
                        data: [10, 15, 8, 12, 20, 25, 18],
                        borderColor: 'rgba(0, 200, 0, 1)',
                        tension: 0.4,
                        pointStyle: 'circle',
                        pointRadius: 5,
                    },
                    {
                        label: 'Clicks',
                        data: [5, 8, 6, 10, 12, 10, 12],
                        borderColor: 'rgba(255, 150, 50, 1)',
                        tension: 0.4,
                        pointStyle: 'circle',
                        pointRadius: 5,
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: { display: true }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { display: true }
                    }
                }
            }
        });
    });

    // Stacked revenue bar chart (optional section)
    const createStackedBarChart = () => {
        const ctx = document.getElementById('rev-chart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May'],
                datasets: [
                    {
                        label: 'Ads Revenue',
                        data: [3000, 4000, 3500, 5000, 4500],
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                    },
                    {
                        label: 'Subscription Revenue',
                        data: [2000, 2500, 2200, 3000, 2800],
                        backgroundColor: 'rgba(153, 102, 255, 0.6)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1,
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Total Revenue Breakdown',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                },
                scales: {
                    x: {
                        stacked: true,
                        title: {
                            display: true,
                            text: 'Months',
                        }
                    },
                    y: {
                        stacked: true,
                        title: {
                            display: true,
                            text: 'Revenue (USD)',
                        },
                        ticks: {
                            beginAtZero: true,
                        }
                    }
                }
            }
        });
    };

    createStackedBarChart();
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>
