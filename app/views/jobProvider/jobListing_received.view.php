<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([2]);?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?=ROOT?>/assets/css/jobProvider/jobListing.css">
<link rel="stylesheet" href="<?=ROOT?>/assets/css/components/empty.css">

<body>
<div class="wrapper flex-row">
    <?php require APPROOT . '/views/jobProvider/jobProvider_sidebar.php'; ?>
    <div class="inclusion-container">
        <?php require APPROOT . '/views/jobProvider/jobListingOpener.php'; ?>

        <div class="category-container">
        <?php require APPROOT . '/views/jobProvider/categoryLinksJobListing.php'; ?>

        </div> <hr> <br>

        <div class="list-header">
            <p class="list-header-title">Received History</p>
            <input type="text" class="search-input" placeholder="Search..."> 
            <button class="filter-btn">Filter</button>
        </div> <br>

        <div class="employee-list">

            <?php if (!empty($data['receivedRequests'])): ?>
            <?php foreach($data['receivedRequests'] as $received): ?>
            <div class="employee-item">
                <div class="employee-photo">
                    <img src="<?=ROOT?>/assets/images/person1.jpg" alt="Profile Picture">
                </div>
                <div class="employee-details">
                    <span class="employee-name"><?= htmlspecialchars($received->fname . ' ' . $received->lname) ?></span>
                    <span class="job-title">Applied Job: <?= htmlspecialchars($received->jobTitle) ?></span>
                    <span class="date-applied">Date Applied: <?= htmlspecialchars($received->dateApplied) ?></span>
                    <span class="time-applied">Time Applied: <?= htmlspecialchars($received->timeApplied)?></span>
                    
                    <div class="ratings">
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    </div>
                    <hr>
                    <span class="jobId-applied">My Job ID: #<?= htmlspecialchars($received->jobID)?></span>
                    <span class="jobId-applied">Application ID: #<?= htmlspecialchars($received->applicationID)?></span>
                </div>
                <button class="accept-jobReq-button btn btn-accent" onclick="confirmAction('accept', '<?= $received->applicationID ?>')">Accept</button>
                <button class="reject-jobReq-button btn btn-danger" onclick="confirmAction('reject', '<?= $received->applicationID ?>')">Reject</button>
                <div class="dropdown">
                    <button class="dropdown-toggle"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                    <ul class="dropdown-menu">
                        <li><a href="#">Message</a></li>
                        <li><a href="#">View Profile</a></li>
                    </ul>
                </div>
            </div>
            <?php endforeach;?>
            <?php else: ?>
                <div class="empty-container">
                    <img src="<?=ROOT?>/assets/images/no-data.png" alt="No Employees" class="empty-icon">
                    <p class="empty-text">No Received Applications Found</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Confirmation Popup -->
        <div id="confirmPopup" class="popup hidden">
            <div class="popup-content">
                <p id="confirmMessage">Are you sure you want to proceed?</p>
                <button class="popup-button-jobReq" id="popup-yes">Yes</button>
                <button class="popup-button-jobReq" id="popup-no" onclick="closePopup('confirmPopup')">Cancel</button>
            </div>
        </div>

        <form id="action-form" action="" method="POST" style="display: none;">
            <input type="hidden" name="applicationID" id="action-applicationID">
        </form>

    </div>
</body>
<script>
    let currentAction = null;
    let currentApplicationID = null;

    function confirmAction(action, applicationID) {
        currentAction = action;
        currentApplicationID = applicationID;
        document.getElementById('confirmMessage').textContent = `Are you sure you want to ${action} this application?`;
        document.getElementById('confirmPopup').classList.remove('hidden');
    }

    document.getElementById('popup-yes').addEventListener('click', function() {
        if (currentAction && currentApplicationID) {
            document.getElementById('action-applicationID').value = currentApplicationID;
            if (currentAction === 'reject') {
                document.getElementById('action-form').action = '<?=ROOT?>/jobProvider/rejectJobRequest';
                document.getElementById('action-form').submit();
            } else if (currentAction === 'accept') {
                document.getElementById('action-form').action = '<?=ROOT?>/jobProvider/acceptJobRequest';
                document.getElementById('action-form').submit();
            }
        }
        closePopup('confirmPopup');
    });

    function closePopup(popupID) {
        document.getElementById(popupID).classList.add('hidden');
    }
</script>
</html>