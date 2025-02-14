<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([2]);?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?=ROOT?>/assets/css/JobProvider/findEmployees.css">
<link rel="stylesheet" href="<?=ROOT?>/assets/css/components/popUp.css"> 

<div class="wrapper flex-row">
    <?php require APPROOT . '/views/seeker/seeker_sidebar.php'; ?>
    
    <div class="main-content-jobs">
        <div class="header">
            <div class="heading">Find Jobs</div>
        </div>
        <hr>
        <div class="search-container">
            <input type="text" 
                class="search-bar" 
                placeholder="Find jobs (e.g. waiter, bartender, skill etc.)"
                aria-label="Search">
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
                <?php foreach($data['findJobs'] as $findJob): ?>
                <div class="job-card container">
                    <div class="job-card-left flex-row">
                      <div class="pfp">
                        <img src="<?=ROOT?>/assets/images/person3.jpg" alt="Profile Picture" class="profile-pic-find-employee">
                      </div>           
                        <div class="job-details">
                            <h2><?= htmlspecialchars($findJob->name . ' ' . $findJob->lname) ?></h2>
                            <h4>Job: <?= htmlspecialchars($findJob->jobTitle) ?></h4>
                            <span class="jobPostedDate"><?= htmlspecialchars($findJob->location) ?></span>
                            <div style="display:flex;flex-direction:column; gap:20px">
                                <div class="rating">
                                    <span>
                                        <i class="fa fa-star star-active mx-1"></i>
                                        <i class="fa fa-star star-active mx-1"></i>
                                        <i class="fa fa-star star-active mx-1"></i>
                                        <i class="fa fa-star star-active mx-1"></i>
                                        <i class="fa fa-star star-active mx-1"></i>
                                    </span>
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
                                <div class="jobDescription"><p><?= $findJob->description ?></p></div>
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
                            </ul>
                        </div>

                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No jobs found.</p>
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
</script>
