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
                <p class="list-header-title">To Be Completed</p>
                <form method="GET" action="<?= ROOT ?>/seeker/jobListing_toBeCompleted">
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

                <?php if (!empty($data['reqAvailableTBC'])): ?>
                    <h2>From Availabilities</h2>
                    <hr>
                    <?php foreach ($data['reqAvailableTBC'] as $tbc): ?>

                        <div class="employee-item">
                            <div class="employee-photo">
                                <div class="img">
                                    <?php if ($tbc->pp): ?>
                                        <?php
                                        $finfo = new finfo(FILEINFO_MIME_TYPE);
                                        $mimeType = $finfo->buffer($tbc->pp);
                                        ?>
                                        <img src="data:<?= $mimeType ?>;base64,<?= base64_encode($tbc->pp) ?>" alt="Employee Image">
                                    <?php else: ?>
                                        <img src="<?= ROOT ?>/assets/images/placeholder.jpg" alt="No image available" height="200px" width="200px">
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="employee-details">
                                <span class="employee-name"><?= htmlspecialchars($tbc->name) ?></span>
                                <span class="job-title"><?= htmlspecialchars($tbc->description) ?></span>
                                <span class="date-applied">Date Applied: <?= htmlspecialchars($tbc->datePosted) ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Time Applied: <?= htmlspecialchars($tbc->timePosted) ?></span>
                                <span class="date-applied">Date Accepted: <?= htmlspecialchars($tbc->dateActioned) ?>&nbsp;&nbsp;&nbsp;Time Accepted: <?= htmlspecialchars($tbc->timeActioned) ?></span>
                                <span class="time-applied">Available Date: <?= htmlspecialchars($tbc->availableDate) ?></span>
                                <span class="time-applied">Available Time: <?= htmlspecialchars($tbc->timeFrom) ?> - <?= htmlspecialchars($tbc->timeTo) ?></span>
                                <span class="time-applied">Salary: <?= htmlspecialchars($tbc->salary) ?> <?= htmlspecialchars($tbc->currency) ?>/Hr</span>
                                <span class="time-applied">Location: <?= htmlspecialchars($tbc->location) ?></span>
                                <div class="rating">
                                    <?php
                                    $stars = 5;
                                    $remaining = $tbc->avgRate;

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
                                <span class="jobId-applied">My Available ID: #<?= htmlspecialchars($tbc->availableID) ?></span>
                                <span class="jobId-applied">Request ID: #<?= htmlspecialchars($tbc->reqID) ?></span>
                            </div>
                            <div class="dropdown">
                                <button class="dropdown-toggle"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Message</a></li>
                                    <li><a href="#">View Profile</a></li>
                                </ul>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php if (!empty($data['applyJobTBC'])): ?>
                    <h2>From Applications</h2>
                    <hr>
                    <?php foreach ($data['applyJobTBC'] as $tbc): ?>

                        <div class="employee-item">
                            <div class="employee-photo">
                                <div class="img">
                                    <?php if ($tbc->pp): ?>
                                        <?php
                                        $finfo = new finfo(FILEINFO_MIME_TYPE);
                                        $mimeType = $finfo->buffer($tbc->pp);
                                        ?>
                                        <img src="data:<?= $mimeType ?>;base64,<?= base64_encode($tbc->pp) ?>" alt="Employee Image">
                                    <?php else: ?>
                                        <img src="<?= ROOT ?>/assets/images/placeholder.jpg" alt="No image available" height="200px" width="200px">
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="employee-details">
                                <span class="employee-name"><?= htmlspecialchars($tbc->name) ?></span>
                                <span class="job-title"><?= htmlspecialchars($tbc->jobTitle) ?></span>
                                <span class="date-applied">Date Applied: <?= htmlspecialchars($tbc->dateApplied) ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Time Applied: <?= htmlspecialchars($tbc->timeApplied) ?></span>
                                <span class="date-applied">Date Accepted: <?= htmlspecialchars($tbc->dateActioned) ?>&nbsp;&nbsp;&nbsp;Time Accepted: <?= htmlspecialchars($tbc->timeActioned) ?></span>
                                <span class="time-applied">Available Date: <?= htmlspecialchars($tbc->availableDate) ?></span>
                                <span class="time-applied">Available Time: <?= htmlspecialchars($tbc->timeFrom) ?> - <?= htmlspecialchars($tbc->timeTo) ?></span>
                                <span class="time-applied">Salary: <?= htmlspecialchars($tbc->salary) ?> <?= htmlspecialchars($tbc->currency) ?>/Hr</span>
                                <span class="time-applied">Location: <?= htmlspecialchars($tbc->location) ?></span>
                                <div class="rating">
                                    <?php
                                    $stars = 5;
                                    $remaining = $tbc->avgRate;

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
                                <span class="jobId-applied">Job ID: #<?= htmlspecialchars($tbc->jobID) ?></span>
                                <span class="jobId-applied">Application ID: #<?= htmlspecialchars($tbc->applicationID) ?></span>
                            </div>
                            <div class="dropdown">
                                <button class="dropdown-toggle"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Message</a></li>
                                    <li><a href="#">View Profile</a></li>
                                </ul>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php if (empty($data['applyJobTBC']) && empty($data['reqAvailableTBC'])): ?>
                    <div class="empty-container">
                        <img src="<?= ROOT ?>/assets/images/no-data.png" alt="Empty" class="empty-icon">
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

    document.querySelector('.search-input').addEventListener('input', function() {
        const searchTerm = this.value;

        fetch(`<?= ROOT ?>/seeker/jobListing_toBeCompleted?search=${encodeURIComponent(searchTerm)}`)
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