<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php';
protectRoute([3]); ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?= ROOT ?>/assets/css/jobProvider/jobListing.css">
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/empty.css">

<body>
    <div class="wrapper flex-row">
        <?php require APPROOT . '/views/jobProvider/organization_sidebar.php'; ?>
        <div class="inclusion-container">
            <?php require APPROOT . '/views/organization/org_jobListingOpener.php'; ?>

            <div class="category-container">
                <?php require APPROOT . '/views/organization/org_categoryLinksJobListing.php'; ?>

            </div>
            <hr> <br>

            <div class="list-header">
                <p class="list-header-title">Expired</p>
                <form method="GET" action="<?= ROOT ?>/organization/org_jobListing_completed">
                    <input type="text" name="search" class="search-input" placeholder="Search..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                </form>
                <input
                    type="date"
                    id="filter-date"
                    class="filter-btn"
                    onchange="filterByDate(this.value)"
                    style="appearance: none; padding: 10px 15px; border: 1px solid #ccc; border-radius: 5px; background-color: #f8f9fa; cursor: pointer; font-size: 16px;" />
            </div>
            <br>

            <div class="employee-list">

                <?php if (!empty($data['applyJobCompleted'])): ?>
                    <h2>From Applications</h2>
                    <hr>
                    <?php foreach ($data['applyJobCompleted'] as $completed): ?>
                        <div class="employee-item">
                            <div class="employee-photo">
                                <div class="img">
                                    <?php if ($completed->pp): ?>
                                        <?php
                                        $finfo = new finfo(FILEINFO_MIME_TYPE);
                                        $mimeType = $finfo->buffer($completed->pp);
                                        ?>
                                        <a href="<?= ROOT ?>/organization/org_viewEmployeeProfile/<?= $completed->accountID ?>">

                                            <img src="data:<?= $mimeType ?>;base64,<?= base64_encode($completed->pp) ?>" alt="Employee Image">
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= ROOT ?>/organization/org_viewEmployeeProfile/<?= $completed->accountID ?>">
                                            <img src="<?= ROOT ?>/assets/images/placeholder.jpg" alt="No image available" height="200px" width="200px">
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="employee-details">
                                <span class="employee-name"><?= htmlspecialchars($completed->fname . ' ' . $completed->lname) ?></span>
                                <span class="job-title"><?= htmlspecialchars($completed->jobTitle) ?></span>
                                <span class="date-applied">Date Applied: <?= htmlspecialchars($completed->dateApplied) ?></span>
                                <span class="time-applied">Time Applied: <?= htmlspecialchars($completed->timeApplied) ?></span>
                                <span class="date-applied">Date Accepted: <?= htmlspecialchars($completed->dateActioned) ?></span>
                                <span class="time-applied">Time Accepted: <?= htmlspecialchars($completed->timeActioned) ?></span>
                                <span class="time-applied">Available Date: <?= htmlspecialchars($completed->availableDate) ?></span>
                                <span class="time-applied">Available Time: <?= htmlspecialchars($completed->timeFrom) ?> - <?= htmlspecialchars($completed->timeTo) ?></span>
                                <span class="time-applied">Salary: <?= htmlspecialchars($completed->salary) ?> <?= htmlspecialchars($completed->currency) ?>/Hr</span>
                                <span class="time-applied">Location: <?= htmlspecialchars($completed->location) ?></span>
                                <hr>
                                <span class="jobId-applied">My Job ID: #<?= htmlspecialchars($completed->jobID) ?></span>
                                <span class="jobId-applied">Application ID: #<?= htmlspecialchars($completed->applicationID) ?></span>
                            </div>
                            <button class="accept-jobReq-button btn btn-accent" onclick="confirmAction('completed', '<?= $completed->applicationID ?>', 'application')">Completed</button>
                            <button class="reject-jobReq-button btn btn-danger" onclick="confirmAction('incompleted', '<?= $completed->applicationID ?>', 'application')">Incompleted</button>
                            <div class="dropdown">
                                <button class="dropdown-toggle"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                                <ul class="dropdown-menu">
                                    <li><a href="<?= ROOT ?>/organization/org_viewEmployeeProfile/<?= $completed->accountID ?>">View Profile</a></li>
                                    <li><a href="<?php echo ROOT; ?>/organization/makeComplaint/<?php echo $completed->applicationID ?>">Complain</a></li>
                                    <li><a href="<?php echo ROOT; ?>/organization/review/<?= $completed->jobID ?>">Review</a></li>
                                </ul>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php if (!empty($data['reqAvailableCompleted'])): ?>
                    <h2>From Requests</h2>
                    <hr>
                    <?php foreach ($data['reqAvailableCompleted'] as $completed): ?>
                        <div class="employee-item">
                            <div class="employee-photo">
                                <div class="img">
                                    <?php if ($completed->pp): ?>
                                        <?php
                                        $finfo = new finfo(FILEINFO_MIME_TYPE);
                                        $mimeType = $finfo->buffer($completed->pp);
                                        ?>
                                        <a href="<?= ROOT ?>/organization/org_viewEmployeeProfile/<?= $completed->accountID ?>">
                                            <img src="data:<?= $mimeType ?>;base64,<?= base64_encode($completed->pp) ?>" alt="Employee Image">
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= ROOT ?>/organization/org_viewEmployeeProfile/<?= $completed->accountID ?>">
                                            <img src="<?= ROOT ?>/assets/images/placeholder.jpg" alt="No image available" height="200px" width="200px">
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="employee-details">
                                <span class="employee-name"><?= htmlspecialchars($completed->fname . ' ' . $completed->lname) ?></span>
                                <span class="job-title"><?= htmlspecialchars($completed->description) ?></span>
                                <span class="date-applied">Date Applied: <?= htmlspecialchars($completed->datePosted) ?></span>
                                <span class="time-applied">Time Applied: <?= htmlspecialchars($completed->timePosted) ?></span>
                                <span class="date-applied">Date Accepted: <?= htmlspecialchars($completed->dateActioned) ?></span>
                                <span class="time-applied">Time Accepted: <?= htmlspecialchars($completed->timeActioned) ?></span>
                                <span class="time-applied">Available Date: <?= htmlspecialchars($completed->availableDate) ?></span>
                                <span class="time-applied">Available Time: <?= htmlspecialchars($completed->timeFrom) ?> - <?= htmlspecialchars($completed->timeTo) ?></span>
                                <span class="time-applied">Salary: <?= htmlspecialchars($completed->salary) ?> <?= htmlspecialchars($completed->currency) ?>/Hr</span>
                                <span class="time-applied">Location: <?= htmlspecialchars($completed->location) ?></span>
                                <hr>
                                <span class="jobId-applied">Available ID: #<?= htmlspecialchars($completed->availableID) ?></span>
                                <span class="jobId-applied">Request ID: #<?= htmlspecialchars($completed->reqID) ?></span>
                            </div>
                            <button class="accept-jobReq-button btn btn-accent" onclick="confirmAction('completed', '<?= $completed->reqID ?>', 'request')">Completed</button>
                            <button class="reject-jobReq-button btn btn-danger" onclick="confirmAction('incompleted', '<?= $completed->reqID ?>', 'request')">Incompleted</button>
                            <div class="dropdown">
                                <button class="dropdown-toggle"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                                <ul class="dropdown-menu">
                                    <li><a href="<?= ROOT ?>/organization/org_viewEmployeeProfile/<?= $completed->accountID ?>">View Profile</a></li>
                                    <li><a href="<?php echo ROOT; ?>/organization/makeComplaint/<?php echo $completed->reqID ?>">Complain</a></li>
                                    <li><a href="<?php echo ROOT; ?>/organization/review/<?= $completed->availableID ?>">Review</a></li>
                                </ul>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php if (empty($data['applyJobCompleted']) && empty($data['reqAvailableCompleted'])): ?>
                    <div class="empty-container">
                        <img src="<?= ROOT ?>/assets/images/no-data.png" alt="Empty" class="empty-icon">
                        <p class="empty-text">Nothing Completed</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <form id="action-form" method="POST" style="display: none;">
            <input type="hidden" name="id" id="action-id">
            <input type="hidden" name="type" id="action-type">
            <input type="hidden" name="status" id="action-status">
        </form>

        <div id="confirmPopup" class="popup hidden">
            <div class="popup-content">
                <p id="confirmMessage">Are you sure you want to proceed?</p>
                <button class="popup-button-jobReq" id="popup-yes">Yes</button>
                <button class="popup-button-jobReq" id="popup-no" onclick="closePopup('confirmPopup')">Cancel</button>
            </div>
        </div>

</body>
<script>
    document.querySelector('.search-input').addEventListener('input', function() {
        const searchTerm = this.value;

        fetch(`<?= ROOT ?>/organization/org_jobListing_completed?search=${encodeURIComponent(searchTerm)}`)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContent = doc.querySelector('.employee-list').innerHTML;
                document.querySelector('.employee-list').innerHTML = newContent;
            })
            .catch(error => console.error('Error:', error));
    });

    function filterByDate(selectedDate) {
        if (!selectedDate) return;

        fetch(`<?= ROOT ?>/organization/org_jobListing_completed?filterDate=${encodeURIComponent(selectedDate)}`)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContent = doc.querySelector('.employee-list').innerHTML;
                document.querySelector('.employee-list').innerHTML = newContent;
            })
            .catch(error => console.error('Error:', error));
    }

    let currentAction = null;
    let currentID = null;
    let currentType = null;

    function confirmAction(action, id, type) {
        currentAction = action;
        currentID = id;
        currentType = type;

        const message = `Are you sure you want to mark this as ${action}?`;
        document.getElementById('confirmMessage').innerHTML = `Are you sure you want to mark this as <strong>${action}</strong>?`;
        document.getElementById('confirmPopup').classList.remove('hidden');
    }

    document.getElementById('popup-yes').addEventListener('click', function() {
        if (currentAction && currentID && currentType) {
            const form = document.getElementById('action-form');
            form.action = `<?= ROOT ?>/organization/updateCompletionStatus`;
            document.getElementById('action-id').value = currentID;
            document.getElementById('action-type').value = currentType;
            document.getElementById('action-status').value = currentAction === 'completed' ? 5 : 6;
            form.submit();
        }
        closePopup('confirmPopup');
    });

    function closePopup(popupID) {
        document.getElementById(popupID).classList.add('hidden');
    }
</script>

</html>