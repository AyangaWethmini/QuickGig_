<?php require APPROOT . '/views/inc/header.php'; ?>

<link rel="stylesheet" href="<?=ROOT?>/assets/css/JobProvider/findEmp.css">
<?php require APPROOT . '/views/components/navbar.php'; ?>

      <div class="wrapper flex-row">
      <?php require APPROOT . '/views/jobProvider/jobProvider_sidebar.php'; ?>
      <div class="main-content">
        
      <div class="job-cards container flex-col">
      <h2>Find Employees</h2>
      <hr style="width: 100%">
      <div class="search-container">
            <input type="text" 
                class="search-bar" 
                placeholder=" Find Employees"
                aria-label="Search" style="height: 20px; width : 700px">
      </div>
          <div class="job-card container">
              <div class="job-card-left flex-row">
                  <div class="pfp">
                    <img src="<?=ROOT?>/assets/images/profile.png" alt="Profile Picture" class="profile-pic">
                  </div>
                
                  <div class="job-details">
                      <h2>Noah Wick</h2>
                      <p>Nomad · Paris, France</p>
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
                            <span>available: 8 a.m. - 4 p.m.</span>
                        </div>
                        <div class="tags">
                            <span class="tag day">Day</span>
                            <span class="tag waiter">Waiter</span>
                            <span class="tag house-cleaning">House-Cleaning</span>
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
                  <img src="<?=ROOT?>/assets/images/profile.png" alt="Profile Picture" class="profile-pic">
                </div>
              
                <div class="job-details">
                    <h2>Noah Wick</h2>
                    <p>Nomad · Paris, France</p>
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
                          <span>available: 8 a.m. - 4 p.m.</span>
                      </div>
                      <div class="tags">
                          <span class="tag day">Day</span>
                          <span class="tag waiter">Waiter</span>
                          <span class="tag house-cleaning">House-Cleaning</span>
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
         

    



