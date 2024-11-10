<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/manager.css"> 

<div class=" wrapper flex-row">
    <div id="sidebar" style="width: 224px; height : 100vh; background-color : var(--brand-lavender)">
    
    </div>
    
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
            <div class="flex-row box container" style="background-color: #56CDAD ;">
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

            </div>
            <div class="messages container flex-col">
                <p>All Requests</p>
                <p class="text-grey">Pending</p>
                <span class="requests">

                </span>
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
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>

 
    