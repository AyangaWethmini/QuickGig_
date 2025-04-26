<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php';
protectRoute([2]); ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?= ROOT ?>/assets/css/jobProvider/jobListing.css">
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/empty.css">

<body>
    <div class="wrapper flex-row">
        <?php require APPROOT . '/views/seeker/seeker_sidebar.php'; ?>
        <div class="inclusion-container">
            <?php require APPROOT . '/views/seeker/jobListingOpener.php'; ?>

            <div class="category-container">
                <?php require APPROOT . '/views/seeker/categoryLinksJobListing.php'; ?>

            </div>
            <hr> <br>

            <div class="list-header">
                <p class="list-header-title">Received History</p>
                <form method="GET" action="<?= ROOT ?>/seeker/jobListing_received">
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

                <?php if (!empty($data['receivedRequests'])): ?>
                    <?php foreach ($data['receivedRequests'] as $received): ?>
                        <div class="employee-item">
                            <div class="employee-photo">
                                <div class="img">
                                    <?php if ($received->pp): ?>
                                        <?php
                                        $finfo = new finfo(FILEINFO_MIME_TYPE);
                                        $mimeType = $finfo->buffer($received->pp);
                                        ?>
                                        <a href="<?= ROOT ?>/seeker/viewEmployeeProfile/<?= $received->accountID ?>">
                                        <img src="data:<?= $mimeType ?>;base64,<?= base64_encode($received->pp) ?>" alt="profile image">
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= ROOT ?>/seeker/viewEmployeeProfile/<?= $received->accountID ?>">
                                        <img src="<?= ROOT ?>/assets/images/placeholder.jpg" alt="No image available">
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="employee-details">
                                <span class="employee-name"><?= htmlspecialchars($received->name) ?></span>
                                <span class="job-title">Description:<?= htmlspecialchars($received->description) ?></span>
                                <span class="date-applied">Date Applied: <?= htmlspecialchars($received->datePosted) ?></span>
                                <span class="time-applied">Time Applied: <?= htmlspecialchars($received->timePosted) ?></span>

                                <div class="rating">
                                    <?php
                                    $stars = 5;
                                    $remaining = $received->avgRate;

                                    for ($i = 0; $i < $stars; $i++) {
                                        if ($remaining >= 1) {
                                            echo '<img src="' . ROOT . '/assets/images/fullstar.png" class="star-img">';
                                            $remaining -= 1;
                                        } elseif ($remaining > 0.5) {
                                            echo '<img src="' . ROOT . '/assets/images/threequarterstar.png" class="star-img">';
                                            $remaining = 0;
                                        } elseif ($remaining == 0.5) {
                                            echo '<img src="' . ROOT . '/assets/images/halfstar.png" class="star-img">';
                                            $remaining = 0;
                                        } elseif ($remaining < 0.5 && $remaining > 0) {
                                            echo '<img src="' . ROOT . '/assets/images/quarterstar.png" class="star-img">';
                                            $remaining = 0;
                                        } else {
                                            echo '<img src="' . ROOT . '/assets/images/emptystar.png" class="star-img">';
                                        }
                                    }

                                    ?>
                                </div>
                                <hr>
                                <span class="jobId-applied">Available ID: #<?= htmlspecialchars($received->availableID) ?></span>
                                <span class="jobId-applied">Request ID: #<?= htmlspecialchars($received->reqID) ?></span>
                            </div>
                            <button class="accept-jobReq-button btn btn-accent" onclick="confirmAction('accept', '<?= $received->reqID ?>')">Accept</button>
                            <button class="reject-jobReq-button btn btn-danger" onclick="confirmAction('reject', '<?= $received->reqID ?>')">Reject</button>
                            <div class="dropdown">
                                <button class="dropdown-toggle"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                                <ul class="dropdown-menu">
                                    <li><a href="<?= ROOT ?>/seeker/viewEmployeeProfile/<?= $received->accountID ?>">View Profile</a></li>
                                </ul>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-container">
                        <img src="<?= ROOT ?>/assets/images/no-data.png" alt="No Employees" class="empty-icon">
                        <p class="empty-text">No Received Requests Found</p>
                    </div>
                <?php endif; ?>

            </div>

            <div id="confirmPopup" class="popup hidden">
                <div class="popup-content">
                    <p id="confirmMessage">Are you sure you want to proceed?</p>
                    <button class="popup-button-jobReq" id="popup-yes">Yes</button>
                    <button class="popup-button-jobReq" id="popup-no" onclick="closePopup('confirmPopup')">Cancel</button>
                </div>
            </div>

            <form id="action-form" action="" method="POST" style="display: none;">
                <input type="hidden" name="reqID" id="action-reqID">
            </form>

        </div>
</body>
<script>
    let currentAction = null;
    let currentReqID = null;

    function confirmAction(action, reqID) {
        currentAction = action;
        currentReqID = reqID;
        document.getElementById('confirmMessage').textContent = `Are you sure you want to ${action} this request?`;
        document.getElementById('confirmPopup').classList.remove('hidden');
    }

    document.getElementById('popup-yes').addEventListener('click', function() {
        if (currentAction && currentReqID) {
            document.getElementById('action-reqID').value = currentReqID;
            if (currentAction === 'reject') {
                document.getElementById('action-form').action = '<?= ROOT ?>/seeker/rejectJobRequest';
                document.getElementById('action-form').submit();
            } else if (currentAction === 'accept') {
                document.getElementById('action-form').action = '<?= ROOT ?>/seeker/acceptJobRequest';
                document.getElementById('action-form').submit();
            }
        }
        closePopup('confirmPopup');
    });

    function closePopup(popupID) {
        document.getElementById(popupID).classList.add('hidden');
    }

    document.querySelector('.search-input').addEventListener('input', function() {
        const searchTerm = this.value;

        fetch(`<?= ROOT ?>/seeker/jobListing_received?search=${encodeURIComponent(searchTerm)}`)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContent = doc.querySelector('.job-list').innerHTML;
                document.querySelector('.job-list').innerHTML = newContent;
            })
            .catch(error => console.error('Error:', error));
    });
</script>

</html>