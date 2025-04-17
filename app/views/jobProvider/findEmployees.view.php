<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([2]);?>
<?php require APPROOT . '/views/components/navbar.php'; ?>


<link rel="stylesheet" href="<?=ROOT?>/assets/css/JobProvider/findEmployees.css">
<link rel="stylesheet" href="<?=ROOT?>/assets/css/components/popUp.css">
<link rel="stylesheet" href="<?=ROOT?>/assets/css/components/empty.css">

<div class="wrapper flex-row">
    <?php require APPROOT . '/views/jobProvider/jobProvider_sidebar.php'; ?>
    
    <div class="main-content-jobs">
        <div class="header">
            <div class="heading">Find Employees</div>
        </div>
        <hr>
        <div class="search-container">
            <input type="text" 
                class="search-bar" 
                placeholder="Find employees (e.g. waiter, bartender, etc. or by name)"
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
            <?php if (!empty($data['findEmployees'])): ?>
            <?php foreach($data['findEmployees'] as $findEmp): ?>
            <div class="job-card container">
                <div class="job-card-left flex-row">
                  <div class="pfp">
                    <div class="img" >
                        <?php if ($findEmp->pp): ?>
                            <?php 
                                $finfo = new finfo(FILEINFO_MIME_TYPE);
                                $mimeType = $finfo->buffer($findEmp->pp);
                            ?>
                            <img src="data:<?= $mimeType ?>;base64,<?= base64_encode($findEmp->pp) ?>" alt="Employee Image">
                        <?php else: ?>
                            <img src="<?=ROOT?>/assets/images/placeholder.jpg" alt="No image available" height="200px" width="200px">
                        <?php endif; ?>
                    </div>
                  </div>           
                    <div class="job-details">
                        <h2><?= htmlspecialchars($findEmp->fname . ' ' . $findEmp->lname) ?></h2>
                        <h4><?= htmlspecialchars($findEmp->description) ?></h4>
                        <span class="jobPostedDate"><?= htmlspecialchars($findEmp->location) ?></span>
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
                        <li><a href="<?= ROOT ?>/message/startConversation/<?= $findEmp->accountID ?>">Message</a></li>

                            <li><a href="<?php echo ROOT;?>/jobProvider/viewEmployeeProfile">View Profile</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
            <?php else: ?>
                <div class="empty-container">
                    <img src="<?=ROOT?>/assets/images/no-data.png" alt="No Employees" class="empty-icon">
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
        fetch("<?= ROOT ?>/jobprovider/requestJob", {
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
</script>