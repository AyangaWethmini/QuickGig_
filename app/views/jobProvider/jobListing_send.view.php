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
            <p class="list-header-title">Send History</p>
            <input type="text" class="search-input" placeholder="Search..."> 
            <button class="filter-btn">Filter</button>
        </div> <br>

        <div class="employee-list">

            <?php if (!empty($data['sendRequests'])): ?>
            <?php foreach($data['sendRequests'] as $received): ?>

            <div class="employee-item">
                <div class="employee-photo">
                    <img src="<?=ROOT?>/assets/images/person3.jpg" alt="Profile Picture">
                </div>
                <div class="employee-details">
                    <span class="employee-name"><?= htmlspecialchars($received->fname . ' ' . $received->lname) ?></span>
                    <span class="job-title"><?= htmlspecialchars($received->description) ?></span>
                    <span class="date-applied">Available Date: <?= htmlspecialchars($received->availableDate) ?></span>
                    <span class="time-applied">Available Time: <?= htmlspecialchars($received->timeFrom)?> - <?= htmlspecialchars($received->timeTo) ?></span>
                    <span class="date-applied">Salary: <?= htmlspecialchars($received->salary) ?> <?= htmlspecialchars($received->currency) ?>/Hr</span>
                    <span class="date-applied">Location: <?= htmlspecialchars($received->location) ?></span>
                    <div class="ratings">
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                    </div>
                    <hr>
                    <span class="date-applied">Date Requested: <?= htmlspecialchars($received->datePosted) ?></span>
                    <span class="time-applied">Time Requested: <?= htmlspecialchars($received->timePosted)?></span>
                    <span class="jobId-applied">ID: #<?= htmlspecialchars($received->reqID)?></span>
                </div>
            
                <button class="reject-jobReq-button btn btn-danger">Cancel</button>
                <div class="dropdown">
                    <button class="dropdown-toggle"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                    <ul class="dropdown-menu">
                        <li><a href="#">Message</a></li>
                        <li><a href="<?php echo ROOT;?>/jobProvider/viewEmployeeProfile">View Profile</a></li>
                    </ul>
                </div>
            </div>
            <?php endforeach;?>
            <?php else: ?>
                <div class="empty-container">
                    <img src="<?=ROOT?>/assets/images/no-data.png" alt="No Employees" class="empty-icon">
                    <p class="empty-text">No Requests Found</p>
                </div>
            <?php endif; ?>

        </div>

        <div id="popup" class="popup hidden">
            <div class="popup-content">
                <p id="popup-message">Are you sure to accept the request?</p>
                <button id="popup-yes" class="popup-button-jobReq">Yes</button>
                <button id="popup-no" class="popup-button-jobReq">No</button>
            </div>
        </div>

    </div>
</body>
<script>
document.querySelectorAll('.accept-jobReq-button').forEach(button => {
    button.addEventListener('click', () => {
        document.getElementById('popup-message').textContent = 'Are you sure to accept the request?';
        document.getElementById('popup').classList.remove('hidden');
    });
});

document.querySelectorAll('.reject-jobReq-button').forEach(button => {
    button.addEventListener('click', () => {
        document.getElementById('popup-message').textContent = 'Are you sure you want to cancel this request?';
        document.getElementById('popup').classList.remove('hidden');
    });
});

document.getElementById('popup-yes').addEventListener('click', () => {
    document.getElementById('popup').classList.add('hidden');
});

document.getElementById('popup-no').addEventListener('click', () => {
    document.getElementById('popup').classList.add('hidden');
});
</script>
</html>