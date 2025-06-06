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
                <form method="GET" action="<?= ROOT ?>/jobProvider/jobListing_send">
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

                <?php if (!empty($data['sendRequests'])): ?>
                    <?php foreach ($data['sendRequests'] as $received): ?>

                        <div class="employee-item">
                            <div class="employee-photo">
                                <div class="img">
                                    <?php if ($received->pp): ?>
                                        <?php
                                        $finfo = new finfo(FILEINFO_MIME_TYPE);
                                        $mimeType = $finfo->buffer($received->pp);
                                        ?>
                                        <a href="<?= ROOT ?>/jobProvider/viewEmployeeProfile/<?= $received->accountID ?>">
                                            <img src="data:<?= $mimeType ?>;base64,<?= base64_encode($received->pp) ?>" alt="Employee Image">
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= ROOT ?>/jobProvider/viewEmployeeProfile/<?= $received->accountID ?>">
                                            <img src="<?= ROOT ?>/assets/images/placeholder.jpg" alt="No image available" height="200px" width="200px">
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="employee-details">
                                <span class="employee-name"><?= htmlspecialchars($received->fname . ' ' . $received->lname) ?></span>
                                <span class="job-title"><?= htmlspecialchars($received->description) ?></span>
                                <span class="date-applied">Available Date: <?= htmlspecialchars($received->availableDate) ?></span>
                                <span class="time-applied">Available Time: <?= htmlspecialchars($received->timeFrom) ?> - <?= htmlspecialchars($received->timeTo) ?></span>
                                <span class="date-applied">Salary: <?= htmlspecialchars($received->salary) ?> <?= htmlspecialchars($received->currency) ?>/Hr</span>
                                <span class="date-applied">Location: <?= htmlspecialchars($received->location) ?></span>
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
                                <span class="date-applied">Date Requested: <?= htmlspecialchars($received->datePosted) ?></span>
                                <span class="time-applied">Time Requested: <?= htmlspecialchars($received->timePosted) ?></span>
                                <span class="jobId-applied">ID: #<?= htmlspecialchars($received->reqID) ?></span>
                            </div>

                            <button class="reject-jobReq-button btn btn-danger" data-req-id="<?= htmlspecialchars($received->reqID) ?>">Cancel</button>
                            <div class="dropdown">
                                <button class="dropdown-toggle"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                                <ul class="dropdown-menu">
                                    <li><a href="<?= ROOT ?>/jobProvider/viewEmployeeProfile/<?= $received->accountID ?>">
                                            View Profile</a></li>
                                </ul>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-container">
                        <img src="<?= ROOT ?>/assets/images/no-data.png" alt="No Employees" class="empty-icon">
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
        fetch('<?= ROOT ?>/jobprovider/deleteSendRequest', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    reqID
                })
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

    document.querySelector('.search-input').addEventListener('input', function() {
        const searchTerm = this.value;

        fetch(`<?= ROOT ?>/jobProvider/jobListing_send?search=${encodeURIComponent(searchTerm)}`)
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

        fetch(`<?= ROOT ?>/jobProvider/jobListing_send?filterDate=${encodeURIComponent(selectedDate)}`)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContent = doc.querySelector('.employee-list').innerHTML;
                document.querySelector('.employee-list').innerHTML = newContent;
            })
            .catch(error => console.error('Error:', error));
    }
    document.getElementById('popup-no').addEventListener('click', () => {
        document.getElementById('popup').classList.add('hidden');
    });
</script>

</html>