<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php';
protectRoute([3]); ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?= ROOT ?>/assets/css/JobProvider/findEmployees.css">
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/popUp.css">
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/empty.css">
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/mapModal.css">

<div class="wrapper flex-row">
    <?php require APPROOT . '/views/jobProvider/organization_sidebar.php'; ?>

    <div class="main-content-jobs">
        <div class="header">
            <div class="heading">Find Employees</div>
        </div>
        
        <div class="search-container">
            <form method="GET" action="<?= ROOT ?>/organization/org_findEmployees">
                <input type="text"
                    name="search"
                    class="search-bar"
                    placeholder="Find employees (e.g. waiter, bartender, etc. or by name)"
                    aria-label="Search"
                    value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
            </form>
            <div class="filter-container">
                <span>Shift:</span>
                <select id="shiftSelect" onchange="updateFilters()">
                    <option value="any">Any</option>
                    <option value="day">Day</option>
                    <option value="night">Night</option>
                </select>

                <span>Date:</span>
                <input type="date" id="datePicker" onchange="updateFilters()">

                <span>Location:</span>
                <input type="text" id="locationInput" placeholder="Enter location" oninput="updateFilters()">
            </div>
        </div>

        <div class="job-cards-container">
            <?php if (!empty($data['findEmployees'])): ?>
                <?php foreach ($data['findEmployees'] as $findEmp): ?>
                    <div class="job-card container">
                        <div class="job-card-left flex-row">
                            <div class="pfp">
                                <div class="img">
                                    <?php if ($findEmp->pp): ?>
                                        <?php
                                        $finfo = new finfo(FILEINFO_MIME_TYPE);
                                        $mimeType = $finfo->buffer($findEmp->pp);
                                        ?>
                                        <a href="<?= ROOT ?>/organization/org_viewEmployeeProfile/<?= $findEmp->accountID ?>">
                                            <img src="data:<?= $mimeType ?>;base64,<?= base64_encode($findEmp->pp) ?>" alt="Employee Image">
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= ROOT ?>/organization/org_viewEmployeeProfile/<?= $findEmp->accountID ?>">
                                            <img src="<?= ROOT ?>/assets/images/placeholder.jpg" alt="No image available" height="200px" width="200px">
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="job-details">
                                <div class="flex-row fit-content">
                                    <div>
                                        <h2><?= htmlspecialchars($findEmp->fname . ' ' . $findEmp->lname) ?></h2>
                                        <h4><?= htmlspecialchars($findEmp->description) ?></h4>
                                    </div>
                                    <?php if ($findEmp->badge == 1): ?>
                                        <img src="<?= ROOT ?>/assets/images/crown.png" class="verify-badge-profile" alt="Verified Badge">
                                    <?php endif; ?>
                                </div>
                                <span class="jobPostedDate"><?= htmlspecialchars($findEmp->location) ?></span>
                                <div style="display:flex;flex-direction:column; gap:20px">
                                    <div class="rating">
                                        <?php
                                        $stars = 5;
                                        $remaining = $findEmp->rating;

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
                                            <span>Available: <?= htmlspecialchars($findEmp->timeFrom) ?> - <?= htmlspecialchars($findEmp->timeTo) ?> </span>
                                        </div>
                                        <div class="availability-date">
                                            <span><?= htmlspecialchars($findEmp->availableDate) ?></span>
                                        </div>
                                        <div class="availability-shift">
                                            <span><?= htmlspecialchars($findEmp->shift) ?></span>
                                        </div>
                                        <div class="availability-salary">
                                            <span><?= htmlspecialchars($findEmp->salary) ?> <?= htmlspecialchars($findEmp->currency) ?>/Hr</span>
                                        </div>
                                    </div>
                                    <div class="tags">
                                        <?php
                                        $categories = json_decode($findEmp->categories, true);
                                        if (is_array($categories)) {
                                            foreach ($categories as $category) {
                                                echo '<span class="tag">' . htmlspecialchars($category) . '</span>';
                                            }
                                        }
                                        ?>
                                    </div>
                                    <hr>
                                    <div class="job-identities">
                                        <p>Posted on: <?= htmlspecialchars($findEmp->datePosted) ?></p>
                                        <p>Posted at: <?= htmlspecialchars($findEmp->timePosted) ?></p>
                                        <p>ID: #<?= htmlspecialchars($findEmp->availableID) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="job-card-right flex-row">
                            <button class="request-button btn btn-accent" onclick="confirmRequest('<?= $findEmp->availableID ?>')">Request</button>
                            <div class="dropdown">
                                <button class="dropdown-toggle"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Message</a></li>
                                    <li><a href="<?= ROOT ?>/organization/org_viewEmployeeProfile/<?= $findEmp->accountID ?>">View Profile</a></li>
                                    <li><a href="#" onclick="viewLocation('<?= htmlspecialchars($findEmp->location) ?>')">View Location</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-container">
                    <img src="<?= ROOT ?>/assets/images/no-data.png" alt="No Employees" class="empty-icon">
                    <p class="empty-text">No Employees Found</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Confirmation Popup -->
<div id="confirmPopup" class="modal">
    <div class="modal-content">
        <p>Are you sure you want to request for this employee?</p>
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
        <p>You have already requested for this.</p>
        <button class="popup-btn-ok" onclick="closePopup('alreadyAppliedPopup')">OK</button>
    </div>
</div>

<!-- Map Modal -->
<div id="mapModal" class="map-modal" style="display:none;">
    <div id="map"></div>
    <div class="mapBtns">
        <button type="button" class="mapBtn" onclick="closeMapModal()">Close</button>
    </div>
</div>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyByhOqNUkNdVh5JDlawmbh-fxmgbVvE2Cg&callback=initMap"></script>
<script>
    let selectedJobID = null;

    function confirmRequest(availableID) {
        selectedJobID = availableID;
        document.getElementById('confirmPopup').style.display = 'flex';
    }

    document.getElementById('confirmYes').addEventListener('click', function() {
        if (selectedJobID) {
            applyForJob(selectedJobID);
        }
        closePopup('confirmPopup');
    });

    function applyForJob(availableID) {
        fetch("<?= ROOT ?>/organization/requestJob", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `jobID=${availableID}`
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
        fetch(`<?= ROOT ?>/organization/org_findEmployees?search=${encodeURIComponent(searchTerm)}`)
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

        setTimeout(() => {
            if (!map) {
                map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 15,
                    center: {
                        lat: 6.9271,
                        lng: 79.8612
                    }
                });
            }

            const geocoder = new google.maps.Geocoder();
            geocoder.geocode({
                address: location
            }, function(results, status) {
                if (status === "OK") {
                    map.setCenter(results[0].geometry.location);
                    if (marker) marker.setMap(null);
                    marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location,
                    });
                } else {
                    alert("Geocode was not successful for the following reason: " + status);
                }
            });
        }, 200);
    }

    function closeMapModal() {
        document.getElementById('mapModal').style.display = 'none';
    }

    function updateFilters() {
        const shiftValue = document.getElementById('shiftSelect').value;
        const dateValue = document.getElementById('datePicker').value;
        const locationValue = document.getElementById('locationInput').value;
        const searchTerm = document.querySelector('.search-bar').value;

        const queryParams = new URLSearchParams({
            search: searchTerm,
            shift: shiftValue,
            date: dateValue,
            location: locationValue
        });

        fetch(`<?= ROOT ?>/organization/org_findEmployees?${queryParams.toString()}`)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContent = doc.querySelector('.job-cards-container').innerHTML;
                document.querySelector('.job-cards-container').innerHTML = newContent;
            })
            .catch(error => console.error('Error:', error));
    }
</script>