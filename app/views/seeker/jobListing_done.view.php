<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([2]);?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?=ROOT?>/assets/css/jobProvider/jobListing.css">
<link rel="stylesheet" href="<?=ROOT?>/assets/css/components/empty.css">

<body>
<div class="wrapper flex-row">
    <?php require APPROOT . '/views/seeker/seeker_sidebar.php'; ?>
    <div class="inclusion-container">
        <?php require APPROOT . '/views/seeker/jobListingOpener.php'; ?>

        <div class="category-container">
        <?php require APPROOT . '/views/seeker/categoryLinksJobListing.php'; ?>

        </div> <hr> <br>

        <div class="list-header">
            <p class="list-header-title">Completed List</p>
            <form method="GET" action="<?= ROOT ?>/seeker/jobListing_completed">
                <input type="text" name="search" class="search-input" placeholder="Search..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
            </form>
            <input 
                type="date" 
                id="filter-date" 
                class="filter-btn" 
                onchange="filterByDate(this.value)" 
                style="appearance: none; padding: 10px 15px; border: 1px solid #ccc; border-radius: 5px; background-color: #f8f9fa; cursor: pointer; font-size: 16px;"
            />
        </div>
        <br>

        <div class="employee-list">

        <?php if (!empty($data['reqAvailableCompleted'])): ?>
            <h2>From Requests</h2><hr>
            <?php foreach($data['reqAvailableCompleted'] as $completed): ?>
                
        <div class="employee-item">
                <div class="employee-photo">
                    <div class="img" >
                        <?php if ($completed->pp): ?>
                            <?php 
                                $finfo = new finfo(FILEINFO_MIME_TYPE);
                                $mimeType = $finfo->buffer($completed->pp);
                            ?>
                            <img src="data:<?= $mimeType ?>;base64,<?= base64_encode($completed->pp) ?>" alt="Employee Image">
                        <?php else: ?>
                            <img src="<?=ROOT?>/assets/images/placeholder.jpg" alt="No image available" height="200px" width="200px">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="employee-details">
                    <span class="employee-name"><?= htmlspecialchars($completed->name) ?></span>
                    <span class="job-title"><?= htmlspecialchars($completed->description) ?></span>
                    <span class="date-applied">Date Applied: <?= htmlspecialchars($completed->datePosted) ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Time Applied: <?= htmlspecialchars($completed->timePosted)?></span>
                    <span class="date-applied">Date Accepted: <?= htmlspecialchars($completed->dateActioned) ?>&nbsp;&nbsp;&nbsp;Time Accepted: <?= htmlspecialchars($completed->timeActioned)?></span>
                    <span class="time-applied">Available Date: <?= htmlspecialchars($completed->availableDate)?></span>
                    <span class="time-applied">Available Time: <?= htmlspecialchars($completed->timeFrom)?> - <?= htmlspecialchars($completed->timeTo)?></span>
                    <span class="time-applied">Salary: <?= htmlspecialchars($completed->salary)?> <?= htmlspecialchars($completed->currency)?>/Hr</span>
                    <span class="time-applied">Location: <?= htmlspecialchars($completed->location)?></span>
                    <hr>
                    <span class="jobId-applied">My Available ID: #<?= htmlspecialchars($completed->availableID)?></span>
                    <span class="jobId-applied">Request ID: #<?= htmlspecialchars($completed->reqID)?></span>
                </div>
                <div class="dropdown">
                    <button class="dropdown-toggle"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo ROOT;?>/seeker/viewEmployeeProfile">View Profile</a></li>
                        <li><a href="<?= ROOT ?>/seeker/makeComplaint/<?= $completed->reqID ?>">Complain</a></li>
                    </ul>
                </div>
            </div>
            <?php endforeach;?>
        <?php endif; ?> 

        <?php if (!empty($data['applyJobCompleted'])): ?>
            <h2>From Applications</h2><hr>
            <?php foreach($data['applyJobCompleted'] as $completed): ?>
                
        <div class="employee-item">
                <div class="employee-photo">
                    <div class="img" >
                        <?php if ($completed->pp): ?>
                            <?php 
                                $finfo = new finfo(FILEINFO_MIME_TYPE);
                                $mimeType = $finfo->buffer($completed->pp);
                            ?>
                            <img src="data:<?= $mimeType ?>;base64,<?= base64_encode($completed->pp) ?>" alt="Employee Image">
                        <?php else: ?>
                            <img src="<?=ROOT?>/assets/images/placeholder.jpg" alt="No image available" height="200px" width="200px">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="employee-details">
                    <span class="employee-name"><?= htmlspecialchars($completed->name) ?></span>
                    <span class="job-title"><?= htmlspecialchars($completed->jobTitle) ?></span>
                    <span class="date-applied">Date Applied: <?= htmlspecialchars($completed->dateApplied) ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Time Applied: <?= htmlspecialchars($completed->timeApplied)?></span>
                    <span class="date-applied">Date Accepted: <?= htmlspecialchars($completed->dateActioned) ?>&nbsp;&nbsp;&nbsp;Time Accepted: <?= htmlspecialchars($completed->timeActioned)?></span>
                    <span class="time-applied">Available Date: <?= htmlspecialchars($completed->availableDate)?></span>
                    <span class="time-applied">Available Time: <?= htmlspecialchars($completed->timeFrom)?> - <?= htmlspecialchars($completed->timeTo)?></span>
                    <span class="time-applied">Salary: <?= htmlspecialchars($completed->salary)?> <?= htmlspecialchars($completed->currency)?>/Hr</span>
                    <span class="time-applied">Location: <?= htmlspecialchars($completed->location)?></span>
                    <hr>
                    <span class="jobId-applied">Job ID: #<?= htmlspecialchars($completed->jobID)?></span>
                    <span class="jobId-applied">Application ID: #<?= htmlspecialchars($completed->applicationID)?></span>
                </div>
                <div class="dropdown">
                    <button class="dropdown-toggle"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo ROOT;?>/seeker/viewEmployeeProfile">View Profile</a></li>
                        <li><a href="<?= ROOT ?>/seeker/makeComplaint/<?= $completed->applicationID ?>">Complain</a></li>
                    </ul>
                </div>
            </div>
            <?php endforeach;?>
        <?php endif; ?> 

        <?php if (empty($data['applyJobCompleted']) && empty($data['reqAvailableCompleted'])): ?>
            <div class="empty-container">
                <img src="<?=ROOT?>/assets/images/no-data.png" alt="Empty" class="empty-icon">
                <p class="empty-text">Nothing Completed</p>
            </div>
        <?php endif; ?> 
        </div>

    </div>
</body>
<script>
    document.querySelector('.search-input').addEventListener('input', function () {
        const searchTerm = this.value;

        fetch(`<?= ROOT ?>/seeker/jobListing_done?search=${encodeURIComponent(searchTerm)}`)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContent = doc.querySelector('.employee-list').innerHTML;
                document.querySelector('.employee-list').innerHTML = newContent;
            })
            .catch(error => console.error('Error:', error));
    });
</script>
</html>