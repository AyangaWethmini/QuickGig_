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
            <p class="list-header-title">To Be Completed</p>
            <input type="text" class="search-input" placeholder="Search..."> 
            <button class="filter-btn">Filter</button>
        </div> <br>

        <div class="employee-list">

        <?php if (!empty($data['applyJobTBC'])): ?>
            <h2>From Applications</h2><hr>
            <?php foreach($data['applyJobTBC'] as $tbc): ?>
                
        <div class="employee-item">
                <div class="employee-photo">
                    <div class="img" >
                        <?php if ($tbc->pp): ?>
                            <?php 
                                $finfo = new finfo(FILEINFO_MIME_TYPE);
                                $mimeType = $finfo->buffer($tbc->pp);
                            ?>
                            <img src="data:<?= $mimeType ?>;base64,<?= base64_encode($tbc->pp) ?>" alt="Employee Image">
                        <?php else: ?>
                            <img src="<?=ROOT?>/assets/images/placeholder.jpg" alt="No image available" height="200px" width="200px">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="employee-details">
                    <span class="employee-name"><?= htmlspecialchars($tbc->fname . ' ' . $tbc->lname) ?></span>
                    <span class="job-title"><?= htmlspecialchars($tbc->jobTitle) ?></span>
                    <span class="date-applied">Date Applied: <?= htmlspecialchars($tbc->dateApplied) ?></span>
                    <span class="time-applied">Time Applied: <?= htmlspecialchars($tbc->timeApplied)?></span>
                    <span class="date-applied">Date Accepted: <?= htmlspecialchars($tbc->dateActioned) ?></span>
                    <span class="time-applied">Time Accepted: <?= htmlspecialchars($tbc->timeActioned)?></span>
                    <div class="ratings">
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                    </div>
                    <hr>
                    <span class="jobId-applied">My Job ID: #<?= htmlspecialchars($tbc->jobID)?></span>
                    <span class="jobId-applied">Application ID: #<?= htmlspecialchars($tbc->applicationID)?></span>
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

        <?php if (!empty($data['reqAvailableTBC'])): ?>
            <h2>From Requests</h2><hr>
            <?php foreach($data['reqAvailableTBC'] as $tbc): ?>
                
        <div class="employee-item">
                <div class="employee-photo">
                    <div class="img" >
                        <?php if ($tbc->pp): ?>
                            <?php 
                                $finfo = new finfo(FILEINFO_MIME_TYPE);
                                $mimeType = $finfo->buffer($tbc->pp);
                            ?>
                            <img src="data:<?= $mimeType ?>;base64,<?= base64_encode($tbc->pp) ?>" alt="Employee Image">
                        <?php else: ?>
                            <img src="<?=ROOT?>/assets/images/placeholder.jpg" alt="No image available" height="200px" width="200px">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="employee-details">
                    <span class="employee-name"><?= htmlspecialchars($tbc->fname . ' ' . $tbc->lname) ?></span>
                    <span class="job-title"><?= htmlspecialchars($tbc->description) ?></span>
                    <span class="date-applied">Date Applied: <?= htmlspecialchars($tbc->datePosted) ?></span>
                    <span class="time-applied">Time Applied: <?= htmlspecialchars($tbc->timePosted)?></span>
                    <span class="date-applied">Date Accepted: <?= htmlspecialchars($tbc->dateActioned) ?></span>
                    <span class="time-applied">Time Accepted: <?= htmlspecialchars($tbc->timeActioned)?></span>
                    <div class="ratings">
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                    </div>
                    <hr>
                    <span class="jobId-applied">Available ID: #<?= htmlspecialchars($tbc->availableID)?></span>
                    <span class="jobId-applied">Request ID: #<?= htmlspecialchars($tbc->reqID)?></span>
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

        <?php if (empty($data['applyJobTBC']) && empty($data['reqAvailableTBC'])): ?>
            <div class="empty-container">
                <img src="<?=ROOT?>/assets/images/no-data.png" alt="Empty" class="empty-icon">
                <p class="empty-text">Nothing To Be Completed</p>
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