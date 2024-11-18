<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/manager.css"> 

<!-- Chart.js CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

<div class="wrapper flex-row">
    <div id="sidebar" style="width: 224px; height: 100vh; background-color: var(--brand-lavender)"></div>
    
    <div class="main-content">
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
                <h1>23</h1>
                <p>Ads posted</p>    
            </div>
            <div class="flex-row box container" style="background-color: #56CDAD;">
                <h1>23</h1>
                <p>Ads posted</p> 
            </div>
            <div class="flex-row box container" style="background-color: #26A4FF;">
                <h1>23</h1>
                <p>Ads posted</p> 
            </div>
            <div class="flex-row box container" style="background-color: #FFB836;">
                <h1>23</h1>
                <p>Ads posted</p> 
            </div>
        </div>
        <hr>
        <div class="manager-sections flex-row">
            <div class="chart-overview container">
                <canvas id="myChart" style="width:100%; max-width:700px"></canvas>
            </div>
            <div class="messages container flex-col">
                <p>All Requests</p>
                <p class="text-grey">Pending</p>
                <span class="requests"></span>
                <a href="#" class="email">Check Emails</a>
            </div>
        </div>
        <div class="flex-row buttons">
            <button class="btn btn-accent">Post Advertisement</button>
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
            type: 'bar', // Chart type: 'bar', 'line', 'pie', etc.
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'], // X-axis labels
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3], // Y-axis data
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{ // Adjust for Chart.js 2.x compatibility
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    });
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>
