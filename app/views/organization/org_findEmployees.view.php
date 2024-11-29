<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([3]);?>
<?php require APPROOT . '/views/components/navbar.php'; ?>


<link rel="stylesheet" href="<?=ROOT?>/assets/css/JobProvider/findEmployees.css">

<div class="wrapper flex-row">
    <?php require APPROOT . '/views/jobProvider/organization_sidebar.php'; ?>
    
    <div class="main-content-jobs">
        <div class="header">
            <div class="heading">Find Employees</div>
        </div>
        <hr>
        <div class="search-container">
            <input type="text" 
                class="search-bar" 
                placeholder="Find emplyees (e.g. waiter, bartender, etc. or by name)"
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
            <div class="job-card container">
                <div class="job-card-left flex-row">
                  <div class="pfp">
                    <img src="<?=ROOT?>/assets/images/person3.jpg" alt="Profile Picture" class="profile-pic-find-employee">
                  </div>           
                    <div class="job-details">
                        <h2>Smith Greenwood</h2>
                        <p>Manchester, UK</p>
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
                                <span>Available: 08:00 AM - 04:00 PM </span>
                            </div>
                            <div class="availability-date">
                                <span>2024-11-30</span>
                            </div>
                        </div>
                        <div class="tags">
                            <span class="tag">Day</span>
                            <span class="tag">Fruit Picker</span>
                            <span class="tag">Weed Remover</span>
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
                            <li><a href="<?php echo ROOT;?>/organization/org_viewEmployeeProfile">View Profile</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="job-card container">
                <div class="job-card-left flex-row">
                  <div class="pfp">
                    <img src="<?=ROOT?>/assets/images/person4.jpg" alt="Profile Picture" class="profile-pic-find-employee">
                  </div>           
                    <div class="job-details">
                        <h2>Zedd Alexis</h2>
                        <p>London, UK</p>
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
                                <span>Available: 08:00 AM - 04:00 PM </span>
                            </div>
                            <div class="availability-date">
                                <span>2024-11-30</span>
                            </div>
                        </div>
                        <div class="tags">
                            <span class="tag">Day</span>
                            <span class="tag">Fruit Picker</span>
                            <span class="tag">Weed Remover</span>
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
                            <li><a href="#">View Profile</a></li>
                        </ul>
                    </div>
                </div>
            </div>   

            <div class="job-card container">
                <div class="job-card-left flex-row">
                  <div class="pfp">
                    <img src="<?=ROOT?>/assets/images/person2.jpg" alt="Profile Picture" class="profile-pic-find-employee">
                  </div>           
                    <div class="job-details">
                        <h2>Sarah Eve</h2>
                        <p>London, UK</p>
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
                                <span>Available: 08:00 AM - 04:00 PM </span>
                            </div>
                            <div class="availability-date">
                                <span>2024-11-30</span>
                            </div>
                        </div>
                        <div class="tags">
                            <span class="tag">Day</span>
                            <span class="tag">Fruit Picker</span>
                            <span class="tag">Weed Remover</span>
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
                            <li><a href="#">View Profile</a></li>
                        </ul>
                    </div>
                </div>
            </div>   

        </div>
    </div>
</div>