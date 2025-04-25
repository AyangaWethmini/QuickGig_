<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php';
protectRoute([2]); ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?= ROOT ?>/assets/css/JobProvider/findEmployees.css">
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/popUp.css">
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/empty.css">
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/mapModal.css">

<div class="wrapper flex-row">
    <?php require APPROOT . '/views/seeker/seeker_sidebar.php'; ?>

    <div class="main-content-jobs">
        <div class="header">
            <div class="heading">Find Jobs</div>
        </div>
        
        <div class="search-container">
            <form method="GET" action="<?= ROOT ?>/seeker/findEmployees">
                <input type="text"
                    name="search"
                    class="search-bar"
                    placeholder="Find jobs (e.g. waiter, bartender, skill etc.)"
                    aria-label="Search"
                    value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
            </form>
            <br><br>
            <div class="filter-container">
                <span>Sort by:</span>
                <select id="sortSelect" onchange="sortContent()">
                    <option value="recent">Latest</option>
                    <option value="views">Oldest</option>
                    <option value="views">Highest rated</option>
                    <option value="views">Highest jobs done</option>
                </select>
            </div>
        </div>

        <div class="job-cards-container">
            <?php if (!empty($data['findJobs'])): ?>
                <?php foreach ($data['findJobs'] as $findJob): ?>
                    <div class="job-card container">
                        <div class="job-card-left flex-row">
                            <div class="pfp">
                                <div class="img">
                                    <?php if ($findJob->pp): ?>
                                        <?php
                                        $finfo = new finfo(FILEINFO_MIME_TYPE);
                                        $mimeType = $finfo->buffer($findJob->pp);
                                        ?>
                                        <a href="<?= ROOT ?>/seeker/viewEmployeeProfile/<?= $findJob->accountID ?>">

                                            <img src="data:<?= $mimeType ?>;base64,<?= base64_encode($findJob->pp) ?>" alt="Employer Image">
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= ROOT ?>/seeker/viewEmployeeProfile/<?= $findJob->accountID ?>">
                                            <img src="<?= ROOT ?>/assets/images/placeholder.jpg" alt="No image available" height="200px" width="200px">
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="job-details">

                                <div class="flex-row fit-content">
                                    <div>

                                        <h2><?= htmlspecialchars($findJob->name) ?></h2>
                                        <h4>Job: <?= htmlspecialchars($findJob->jobTitle) ?></h4>
                                    </div>
                                    <?php if ($findJob->badge == 1): ?>
                                        <img src="<?= ROOT ?>/assets/images/crown.png" class="verify-badge-profile" alt="Verified Badge">
                                    <?php endif; ?>

                                </div>
                                <span class="jobPostedDate"><?= htmlspecialchars($findJob->location) ?></span>
                                <div style="display:flex;flex-direction:column; gap:20px">
                                    <div class="rating">
                                        <?php
                                        $stars = 5;
                                        $remaining = $findJob->rating;

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
                                    <div class="availability">
                                        <div class="availability-time">
                                            <span>Available: <?= htmlspecialchars($findJob->timeFrom) ?> - <?= htmlspecialchars($findJob->timeTo) ?></span>
                                        </div>
                                        <div class="availability-date">
                                            <span><?= htmlspecialchars($findJob->availableDate) ?></span>
                                        </div>
                                        <div class="availability-shift">
                                            <span><?= htmlspecialchars($findJob->shift) ?></span>
                                        </div>
                                        <div class="availability-salary">
                                            <span><?= htmlspecialchars($findJob->salary) ?> <?= htmlspecialchars($findJob->currency) ?>/Hr</span>
                                        </div>
                                    </div>
                                    <div class="tags">
                                        <?php
                                        $categories = json_decode($findJob->categories, true);
                                        if (is_array($categories)) {
                                            foreach ($categories as $category) {
                                                echo '<span class="tag">' . htmlspecialchars($category) . '</span>';
                                            }
                                        }
                                        ?>
                                    </div>
                                    <hr>
                                    <div class="jobDescription">
                                        <p><?= $findJob->description ?></p>
                                    </div>
                                    <hr>
                                    <div class="job-identities">
                                        <p>Posted on: <?= htmlspecialchars($findJob->datePosted) ?></p>
                                        <p>Posted at: <?= htmlspecialchars($findJob->timePosted) ?></P>
                                        <p>Job id: #<?= htmlspecialchars($findJob->jobID) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="job-card-right flex-row">
                            <button class="request-button btn btn-accent" onclick="confirmRequest('<?= $findJob->jobID ?>')">Request</button>
                            <div class="dropdown">
                                <button class="dropdown-toggle">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Message</a></li>
                                    <li><a href="<?php echo ROOT; ?>/seeker/viewEmployeeProfile">View Profile</a></li>
                                    <li><a href="#" onclick="viewLocation('<?= htmlspecialchars($findJob->location) ?>')">View Location</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-container">
                    <img src="<?= ROOT ?>/assets/images/no-data.png" alt="No Jobs" class="empty-icon">
                    <p class="empty-text">No Jobs Found</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Confirmation Popup -->
<div id="confirmPopup" class="modal">
    <div class="modal-content">
        <p>Are you sure you want to request this job?</p>
        <button class="popup-btn-add" id="confirmYes">Yes</button>
        <button class="popup-btn-cancel" onclick="closePopup('confirmPopup')">Cancel</button>
    </div>
</div>

<!-- Success Popup -->
<div id="successPopup" class="modal">
    <div class="modal-content">
        <p>Your request has been submitted successfully!</p>
    </div>
</div>

<!-- Already Applied Popup -->
<div id="alreadyAppliedPopup" class="modal">
    <div class="modal-content">
        <p>You have already applied for this job.</p>
        <button class="popup-btn-ok" onclick="closePopup('alreadyAppliedPopup')">OK</button>
    </div>
</div>

<div id="mapModal" class="map-modal" style="display:none;">
    <div id="map"></div>
    <div class="mapBtns">
        <button type="button" class="mapBtn" onclick="closeMapModal()">Close</button>
    </div>
</div>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyByhOqNUkNdVh5JDlawmbh-fxmgbVvE2Cg&callback=initMap"></script>
<script>
    let selectedJobID = null;

    function confirmRequest(jobID) {
        selectedJobID = jobID;
        document.getElementById('confirmPopup').style.display = 'flex';
    }

    document.getElementById('confirmYes').addEventListener('click', function() {
        if (selectedJobID) {
            applyForJob(selectedJobID);
        }
        closePopup('confirmPopup');
    });

    function applyForJob(jobID) {
        fetch("<?= ROOT ?>/seeker/requestJob", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `jobID=${jobID}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    showPopup("successPopup");
                    setTimeout(() => closePopup("successPopup"), 3000);
                } else if (data.status === "error") {
                    showPopup("alreadyAppliedPopup");
                }
            })
            .catch(error => console.error("Error:", error));
    }

    function showPopup(popupID) {
        document.getElementById(popupID).style.display = 'flex';
    }

    function closePopup(popupID) {
        document.getElementById(popupID).style.display = 'none';
    }

    document.querySelector('.search-bar').addEventListener('input', function() {
        const searchTerm = this.value;
        fetch(`<?= ROOT ?>/seeker/findEmployees?search=${encodeURIComponent(searchTerm)}`)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContent = doc.querySelector('.job-cards-container').innerHTML;
                document.querySelector('.job-cards-container').innerHTML = newContent;
            })
            .catch(error => console.error('Error:', error));
    });

    let map;
    let marker;

    function viewLocation(location) {
        const modal = document.getElementById('mapModal');
        modal.style.display = 'block';

        // Initialize map
        setTimeout(() => {
            if (!map) {
                map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 15,
                    center: {
                        lat: 6.9271,
                        lng: 79.8612
                    }, // Default to Colombo
                });
            }

            const geocoder = new google.maps.Geocoder();
            geocoder.geocode({
                address: location
            }, function(results, status) {
                if (status === "OK") {
                    map.setCenter(results[0].geometry.location);
                    if (marker) {
                        marker.setMap(null);
                    }
                    marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location,
                    });
                } else {
                    alert("Geocode was not successful for the following reason: " + status);
                }
            });
        }, 200); // Delay to ensure modal is rendered
    }

    function closeMapModal() {
        document.getElementById('mapModal').style.display = 'none';
    }
</script>