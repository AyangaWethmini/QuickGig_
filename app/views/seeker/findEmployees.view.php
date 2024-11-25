<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>


<link rel="stylesheet" href="<?=ROOT?>/assets/css/JobProvider/findEmployees.css">

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
                placeholder="Find jobss (e.g. waiter, bartender, day, skill etc. or by a name)"
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
                        <h2>Waiter for a bar</h2>
                        <p>Miami, USA</p>
                        <p>$14.50/hour</p>
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
                                    <span>Time: 07:00 PM - 01:30 AM </span>
                                </div>
                                <div class="availability-date">
                                    <span>Date: 2024-11-30</span>
                                </div>
                            </div>
                            <div class="tags">
                                <span class="tag">Night</span>
                                <span class="tag">Waiter</span>
                                <span class="tag">English</span>
                                <span class="tag">Diligent</span>
                            </div> <hr>
                            <div class="job-identities">
                            <p>Posted on: 2024-11-26</p>
                            <p>Posted at: 01:57 PM</P>
                            <p>Job id: #1</p>
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
                            <li><a href="<?php echo ROOT;?>/seeker/viewEmployeeProfile">View Profile</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="job-card container">
                <div class="job-card-left flex-row">
                  <div class="pfp">
                    <img src="<?=ROOT?>/assets/images/organization1.png" alt="Profile Picture" class="profile-pic-find-employee">
                  </div>           
                    <div class="job-details">
                        <h2>Need fruitpickers</h2>
                        <p>Texas, USA</p>
                        <p>$16.75/hour</p>
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
                                    <span>Time: 07:00 AM - 04:30 PM </span>
                                </div>
                                <div class="availability-date">
                                    <span>Date: 2024-11-30</span>
                                </div>
                            </div>
                            <div class="tags">
                                <span class="tag">Day</span>
                                <span class="tag">Fruit-Picker</span>
                                <span class="tag">Diligent</span>
                            </div> <hr>
                            <div class="job-identities">
                            <p>Posted on: 2024-11-26</p>
                            <p>Posted at: 03:37 PM</P>
                            <p>Job id: #1</p>
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
                            <li><a href="<?php echo ROOT;?>/seeker/viewEmployeeProfile">View Profile</a></li>
                        </ul>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>