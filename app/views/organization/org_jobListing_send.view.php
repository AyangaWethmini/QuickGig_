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
            <p class="list-header-title">Send History</p>
            <input type="text" class="search-input" placeholder="Search..."> 
            <button class="filter-btn">Filter</button>
        </div> <br>

        <div class="employee-list">

            <?php if (!empty($data['sendRequests'])): ?>
            <?php foreach($data['sendRequests'] as $received): ?>

            <div class="employee-item">
                <div class="employee-photo">
                    <div class="img" >
                        <?php if ($received->pp): ?>
                            <?php 
                                $finfo = new finfo(FILEINFO_MIME_TYPE);
                                $mimeType = $finfo->buffer($received->pp);
                            ?>
                            <img src="data:<?= $mimeType ?>;base64,<?= base64_encode($received->pp) ?>" alt="Employee Image">
                        <?php else: ?>
                            <img src="<?=ROOT?>/assets/images/placeholder.jpg" alt="No image available" height="200px" width="200px">
                        <?php endif; ?>
                    </div>
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
            
                <button class="reject-jobReq-button btn btn-danger" data-req-id="<?= htmlspecialchars($received->reqID) ?>">Cancel</button>
                <div class="dropdown">
                    <button class="dropdown-toggle"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                    <ul class="dropdown-menu">
                        <li><a href="#">Message</a></li>
                        <li><a href="<?php echo ROOT;?>/organization/org_viewEmployeeProfile">View Profile</a></li>
                    </ul>
                </div>
            </div>
            <?php endforeach;?>
            <?php else: ?>
                <div class="empty-container">
                    <img src="<?=ROOT?>/assets/images/no-data.png" alt="No Employees" class="empty-icon">
                    <p class="empty-text">No Sent Requests Found</p>
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
document.querySelectorAll('.reject-jobReq-button').forEach(button => {
    button.addEventListener('click', (event) => {
        const reqID = event.target.dataset.reqId;
        document.getElementById('popup-message').textContent = 'Are you sure you want to cancel this request?';
        document.getElementById('popup').classList.remove('hidden');
        document.getElementById('popup-yes').dataset.reqId = reqID;
    });
});

document.getElementById('popup-yes').addEventListener('click', () => {
    const reqID = document.getElementById('popup-yes').dataset.reqId;
    fetch('<?=ROOT?>/organization/deleteSendRequest', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ reqID })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            location.reload();
        } else {
            alert('Failed to delete the request.');
        }
    });
    document.getElementById('popup').classList.add('hidden');
});

document.getElementById('popup-no').addEventListener('click', () => {
    document.getElementById('popup').classList.add('hidden');
});
</script>

</html>