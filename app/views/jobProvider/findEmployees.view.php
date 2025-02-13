<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([2]);?>
<?php require APPROOT . '/views/components/navbar.php'; ?>


<link rel="stylesheet" href="<?=ROOT?>/assets/css/JobProvider/findEmployees.css">

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
            <?php foreach($data['findEmployees'] as $findEmp): ?>
            <div class="job-card container">
                <div class="job-card-left flex-row">
                  <div class="pfp">
                    <img src="<?=ROOT?>/assets/images/person3.jpg" alt="Profile Picture" class="profile-pic-find-employee">
                  </div>           
                    <div class="job-details">
                        <h2><?= htmlspecialchars($findEmp->fname . ' ' . $findEmp->lname) ?></h2>
                        <p><?= htmlspecialchars($findEmp->location) ?></p>
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
                        <div class="jobPostedDateTime">
                        <span class="jobPostedDate">Posted on: <?= htmlspecialchars($findEmp->datePosted) ?></span>
                        <span class="jobPostedTime">Posted at: <?= htmlspecialchars($findEmp->timePosted) ?></span>
                        <span class="jobPostedTime">ID: #<?= htmlspecialchars($findEmp->availableID) ?></span>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="job-card-right flex-row">
                  <button class="request-button btn btn-accent">Request</button>
                    <div class="dropdown">
                        <button class="dropdown-toggle"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Message</a></li>
                            <li><a href="<?php echo ROOT;?>/jobProvider/viewEmployeeProfile">View Profile</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php endforeach;?>   
        </div>
    </div>
</div>