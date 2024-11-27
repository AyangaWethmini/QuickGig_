<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/manager.css"> 

<!-- Chart.js CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

<div class="wrapper flex-row">
    <?php require APPROOT . '/views/manager/manager_sidebar.php'; ?>
    
    <div class="main-content container">
        <div class="header flex-row">
            <span class="greeting container">
                <h3>Good morning! Maria</h3>
                <p class="text-grey">Here is the statistics from 12th July - 12th August</p>
            </span>
            <span class="date">
                <div class="date-selector" onclick="openModal()">
                    <span id="dateRange" class="date-text">Select Date Range</span>
                    <i class="fas fa-calendar-alt calendar-icon"></i>
                </div>

                <!-- Date range modal -->
                <div id="dateModal" class="modal">
                    <div class="modal-content">
                        <h3>Select Date Range</h3>
                        <input type="date" id="startDate" placeholder="Start Date" />
                        <input type="date" id="endDate" placeholder="End Date" />
                        <div class="modal-buttons">
                            <button class="cancel-btn" onclick="closeModal()">Cancel</button>
                            <button class="apply-btn" onclick="applyDateRange()">Apply</button>
                        </div>
                    </div>
                </div>
            </span>
        </div>

        <div class="overview flex-row">
            <div class="flex-row box container" style="background-color: var(--brand-primary);">
                <div><h1>23</h1></div>
                <div><p>Ads Posted</p></div>    
            </div>
            <div class="flex-row box container" style="background-color: #56CDAD;">
                <div><h1>23</h1></div>
                <div><p>Ads Posted</p></div> 
            </div>
            <div class="flex-row box container" style="background-color: #26A4FF;">
                <div><h1>23</h1></div>
                <div><p>Ads Posted</p></div> 
            </div>
            <div class="flex-row box container" style="background-color: #FFB836;">
                <div><h1>23</h1></div>
                <div><p>Ads Posted</p></div> 
            </div>
        </div>
        <hr><br>
        <div class="manager-sections flex-row">
            <div class="chart-overview container flex-row">
                <canvas id="myChart" style="width:100%; max-width:700px"></canvas>
                <div class="count flex-col">
                    <div class="views">
                        <p class="title">
                            Ads views
                        </p>
                        <p class="number">
                            2135
                        </p>
                        <p class="grey-text">
                            this week
                        </p>
                    </div>
                    <div class="clicks">
                    <p class="ctitle">
                            Ads views
                        </p>
                        <p class="number">
                            2135
                        </p>
                        <p class="grey-text">
                            this week
                        </p>
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
                <a href="#" class="email">Check Emails</a>
            </div>
        </div>
        <div class="flex-row buttons">
            <button class="btn btn-accent" onclick="window.location.href='<?=APPROOT?>views/manager/advertisement.view.php'">Post Advertisement</button>
            <button class="btn btn-accent">Review Ads</button>
        </div>
    </div>
</div>

<script>
    // Modal functionality
    const dateModal = document.getElementById('dateModal');
    const startDateInput = document.getElementById('startDate');
    const endDateInput = document.getElementById('endDate');
    const dateRangeDisplay = document.getElementById('dateRange');

    function openModal() { 
        dateModal.style.display = 'flex';
    }

    function closeModal() {
        dateModal.style.display = 'none';
    }

    function applyDateRange() {
        const options = { month: 'short', day: 'numeric' };
        const start = new Date(startDateInput.value).toLocaleDateString('en-US', options);
        const end = new Date(endDateInput.value).toLocaleDateString('en-US', options);

        if (startDateInput.value && endDateInput.value) {
            dateRangeDisplay.textContent = `${start} – ${end}`;
            closeModal(); 
        } else {
            alert("Please select both start and end dates.");
        }
    }

    // Chart.js functionality
    document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('myChart').getContext('2d');

    new Chart(ctx, {
        type: 'line', // Line chart
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'], // X-axis labels (days of the week)
            datasets: [
                {
                    label: 'Views',
                    data: [10, 15, 8, 12, 20, 25, 18], // Y-axis data for Views
                    borderColor: 'rgba(0, 200, 0, 1)', // Green line
                    tension: 0.4, // Smooth curve
                    pointStyle: 'circle',
                    pointRadius: 5,
                },
                {
                    label: 'Clicks',
                    data: [5, 8, 6, 10, 12, 10, 12], // Y-axis data for Clicks
                    borderColor: 'rgba(255, 150, 50, 1)', // Orange line
                    tension: 0.4, // Smooth curve
                    pointStyle: 'circle',
                    pointRadius: 5,
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom', // Legend at the bottom
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    grid: {
                        display: true,
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        display: true,
                    }
                }
            }
        }
    });
});

    
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>



