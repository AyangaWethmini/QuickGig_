<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php';
protectRoute([2]); ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?= ROOT ?>/assets/css/jobProvider/jobListing.css">
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/empty.css">

<body>
    <div class="wrapper flex-row">
        <?php require APPROOT . '/views/jobProvider/jobProvider_sidebar.php'; ?>
        <div class="inclusion-container">
            <?php require APPROOT . '/views/jobProvider/jobListingOpener.php'; ?>

            <div class="category-container">
                <?php require APPROOT . '/views/jobProvider/categoryLinksJobListing.php'; ?>

            </div>
            <hr> <br>

            <div class="list-header">
                <form method="GET" action="<?= ROOT ?>/jobProvider/jobListing_ongoing">
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

                <?php if (!empty($data['applyJobOngoing'])): ?>
                    <h2>From Applications</h2>
                    <hr>
                    <?php foreach ($data['applyJobOngoing'] as $ongoing): ?>

                        <div class="employee-item">
                            <div class="ongoing-job-indicator"></div>
                            <div class="employee-photo">
                                <div class="img">
                                    <?php if ($ongoing->pp): ?>
                                        <?php
                                        $finfo = new finfo(FILEINFO_MIME_TYPE);
                                        $mimeType = $finfo->buffer($ongoing->pp);
                                        ?>
                                        <a href="<?= ROOT ?>/jobProvider/viewEmployeeProfile/<?= $ongoing->accountID ?>">
                                            <img src="data:<?= $mimeType ?>;base64,<?= base64_encode($ongoing->pp) ?>" alt="Employee Image">
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= ROOT ?>/jobProvider/viewEmployeeProfile/<?= $ongoing->accountID ?>">
                                            <img src="<?= ROOT ?>/assets/images/placeholder.jpg" alt="No image available" height="200px" width="200px">
                                        </a>
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
                                <span class="jobId-applied">My Job ID: #<?= htmlspecialchars($ongoing->jobID) ?></span>
                                <span class="jobId-applied">Application ID: #<?= htmlspecialchars($ongoing->applicationID) ?></span>
                            </div>
                            <div class="dropdown">
                                <button class="dropdown-toggle"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                                <ul class="dropdown-menu">
                                    <li><a href="<?= ROOT ?>/jobProvider/viewEmployeeProfile/<?= $ongoing->accountID ?>">View Profile</a></li>
                                </ul>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php if (!empty($data['reqAvailableOngoing'])): ?>
                    <h2>From Requests</h2>
                    <hr>
                    <?php foreach ($data['reqAvailableOngoing'] as $ongoing): ?>

                        <div class="employee-item">
                            <div class="ongoing-job-indicator"></div>
                            <div class="employee-photo">
                                <div class="img">
                                    <?php if ($ongoing->pp): ?>
                                        <?php
                                        $finfo = new finfo(FILEINFO_MIME_TYPE);
                                        $mimeType = $finfo->buffer($ongoing->pp);
                                        ?>
                                        <a href="<?= ROOT ?>/jobProvider/viewEmployeeProfile/<?= $ongoing->accountID ?>">
                                            <img src="data:<?= $mimeType ?>;base64,<?= base64_encode($ongoing->pp) ?>" alt="Employee Image">
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= ROOT ?>/jobProvider/viewEmployeeProfile/<?= $ongoing->accountID ?>">
                                            <img src="<?= ROOT ?>/assets/images/placeholder.jpg" alt="No image available" height="200px" width="200px">
                                        </a>
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
                                <span class="jobId-applied">Available ID: #<?= htmlspecialchars($ongoing->availableID) ?></span>
                                <span class="jobId-applied">Request ID: #<?= htmlspecialchars($ongoing->reqID) ?></span>
                            </div>
                            <div class="dropdown">
                                <button class="dropdown-toggle"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                                <ul class="dropdown-menu">
                                    <li><a href="<?= ROOT ?>/jobProvider/viewEmployeeProfile/<?= $ongoing->accountID ?>">View Profile</a></li>
                                </ul>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php if (empty($data['applyJobOngoing']) && empty($data['reqAvailableOngoing'])): ?>
                    <div class="empty-container">
                        <img src="<?= ROOT ?>/assets/images/no-data.png" alt="Empty" class="empty-icon">
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

    document.querySelector('.search-input').addEventListener('input', function() {
        const searchTerm = this.value;

        fetch(`<?= ROOT ?>/jobProvider/jobListing_ongoing?search=${encodeURIComponent(searchTerm)}`)
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

        fetch(`<?= ROOT ?>/jobProvider/jobListing_ongoing?filterDate=${encodeURIComponent(selectedDate)}`)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContent = doc.querySelector('.employee-list').innerHTML;
                document.querySelector('.employee-list').innerHTML = newContent;
            })
            .catch(error => console.error('Error:', error));
    }
</script>

</html>