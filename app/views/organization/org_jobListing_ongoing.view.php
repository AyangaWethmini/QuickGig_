<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([3]);?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?=ROOT?>/assets/css/jobProvider/jobListing.css">
<link rel="stylesheet" href="<?=ROOT?>/assets/css/components/empty.css">

<body>
<div class="wrapper flex-row">
    <?php require APPROOT . '/views/jobProvider/organization_sidebar.php'; ?>
    <div class="inclusion-container">
        <?php require APPROOT . '/views/organization/org_jobListingOpener.php'; ?>

        <div class="category-container">
        <?php require APPROOT . '/views/organization/org_categoryLinksJobListing.php'; ?>

        </div> <hr> <br>

        <div class="list-header">
            <p class="list-header-title">Ongoing List</p>
            <input type="text" class="search-input" placeholder="Search..."> 
            <button class="filter-btn">Filter</button>
        </div> <br>

        <div class="employee-list">

        <?php if (!empty($data['applyJobOngoing'])): ?>
            <h2>From Applications</h2><hr>
            <?php foreach($data['applyJobOngoing'] as $ongoing): ?>
                
        <div class="employee-item">
                <div class="ongoing-job-indicator"></div>
                <div class="employee-photo">
                    <div class="img" >
                        <?php if ($ongoing->pp): ?>
                            <?php 
                                $finfo = new finfo(FILEINFO_MIME_TYPE);
                                $mimeType = $finfo->buffer($ongoing->pp);
                            ?>
                            <img src="data:<?= $mimeType ?>;base64,<?= base64_encode($ongoing->pp) ?>" alt="Employee Image">
                        <?php else: ?>
                            <img src="<?=ROOT?>/assets/images/placeholder.jpg" alt="No image available" height="200px" width="200px">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="employee-details">
                    <span class="employee-name"><?= htmlspecialchars($ongoing->fname . ' ' . $ongoing->lname) ?></span>
                    <span class="job-title"><?= htmlspecialchars($ongoing->jobTitle) ?></span>
                    <span class="date-available">Date: <?= htmlspecialchars($ongoing->availableDate) ?> (Today)</span>
                    <span class="time-available">Time: <?= htmlspecialchars($ongoing->timeFrom) ?> - <?= htmlspecialchars($ongoing->timeTo) ?></span>
                    <span class="hourly-pay">Salary: <?= htmlspecialchars($ongoing->salary) ?> <?= htmlspecialchars($ongoing->currency) ?>/Hr</span>
                    <hr>
                    <span class="date-applied">Date Accepted: <?= htmlspecialchars($ongoing->dateActioned) ?></span>
                    <span class="date-applied">Time Accepted: <?= htmlspecialchars($ongoing->timeActioned) ?></span>
                    <span class="jobId-applied">My Job ID: #<?= htmlspecialchars($ongoing->jobID)?></span>
                    <span class="jobId-applied">Application ID: #<?= htmlspecialchars($ongoing->applicationID)?></span>
                </div>
                <div class="dropdown">
                    <button class="dropdown-toggle"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                    <ul class="dropdown-menu">
                        <li><a href="#">Message</a></li>
                        <li><a href="#">View Profile</a></li>
                    </ul>
                </div>
            </div>
            <?php endforeach;?>
        <?php endif; ?> 

        <?php if (!empty($data['reqAvailableOngoing'])): ?>
            <h2>From Requests</h2><hr>
            <?php foreach($data['reqAvailableOngoing'] as $ongoing): ?>
                
        <div class="employee-item">
                <div class="ongoing-job-indicator"></div>
                <div class="employee-photo">
                    <div class="img" >
                        <?php if ($ongoing->pp): ?>
                            <?php 
                                $finfo = new finfo(FILEINFO_MIME_TYPE);
                                $mimeType = $finfo->buffer($ongoing->pp);
                            ?>
                            <img src="data:<?= $mimeType ?>;base64,<?= base64_encode($ongoing->pp) ?>" alt="Employee Image">
                        <?php else: ?>
                            <img src="<?=ROOT?>/assets/images/placeholder.jpg" alt="No image available" height="200px" width="200px">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="employee-details">
                    <span class="employee-name"><?= htmlspecialchars($ongoing->fname . ' ' . $ongoing->lname) ?></span>
                    <span class="job-title"><?= htmlspecialchars($ongoing->description) ?></span>
                    <span class="date-available">Date: <?= htmlspecialchars($ongoing->availableDate) ?> (Today)</span>
                    <span class="time-available">Time: <?= htmlspecialchars($ongoing->timeFrom) ?> - <?= htmlspecialchars($ongoing->timeTo) ?></span>
                    <span class="hourly-pay">Salary: <?= htmlspecialchars($ongoing->salary) ?> <?= htmlspecialchars($ongoing->currency) ?>/Hr</span>
                    <hr>
                    <span class="date-applied">Date Accepted: <?= htmlspecialchars($ongoing->dateActioned) ?></span>
                    <span class="date-applied">Time Accepted: <?= htmlspecialchars($ongoing->timeActioned) ?></span>
                    <span class="jobId-applied">Available ID: #<?= htmlspecialchars($ongoing->availableID)?></span>
                    <span class="jobId-applied">Request ID: #<?= htmlspecialchars($ongoing->reqID)?></span>
                </div>
                <div class="dropdown">
                    <button class="dropdown-toggle"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                    <ul class="dropdown-menu">
                        <li><a href="#">Message</a></li>
                        <li><a href="#">View Profile</a></li>
                    </ul>
                </div>
            </div>
            <?php endforeach;?>
        <?php endif; ?> 

        <?php if (empty($data['applyJobOngoing']) && empty($data['reqAvailableOngoing'])): ?>
            <div class="empty-container">
                <img src="<?=ROOT?>/assets/images/no-data.png" alt="Empty" class="empty-icon">
                <p class="empty-text">Nothing Ongoing</p>
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