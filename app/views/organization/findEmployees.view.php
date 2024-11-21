<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?=ROOT?>/assets/css/JobProvider/findEmp.css">

<!-- 
<div class="header container">
    <p class="logo">Quickgig</p>
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
            <button class="btn btn-accent srch-btn" >Search my job</button>
        </div>
    </div>
</div>

<div class="emp-suggestions flex-row">
    <div class="filter-emp">
        <p>Type of Employment</p>
        <input type="checkbox">Daytime
        <input type="checkbox">Night-time
        <input type="checkbox">Weekend

        <p>Categories</p>
        <input type="checkbox">Gardening
        <input type="checkbox">Helper
        <input type="checkbox">Baby sitting
        <input type="checkbox">Delivery
        <input type="checkbox">Tutoring
        <input type="checkbox">Cooking
        <input type="checkbox">Cleaning
        <input type="checkbox">Rent Vehicle
        <input type="checkbox">Pet sitting
        <input type="checkbox">Eldery care
    </div>
    <div class="employees flex-col">
        <div class="filter-container">
                <span>Employee Suggestions</span>
                <select id="sortSelect" onchange="sortContent()">
                    <option value="recent">Most recent</option>
                    <option value="views">Highest views</option>
                </select>
                <button id="gridButton" onclick="toggleView()">☰</button>
        </div>

         -->
<div class="wrapper flex-row">
        <?php require APPROOT . '/views/jobProvider/jobProvider_sidebar.php'; ?>
         <div class="job-cards container flex-col">
    <!-- First Job Card -->
     
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
                      <span>available: 8 a.m. - 4 p.m.</span>
                  </div>
                  <div class="tags">
                      <span class="tag day">Day</span>
                      <span class="tag waiter">Waiter</span>
                      <span class="tag house-cleaning">Bartender</span>
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
                <li><a href="<?php echo ROOT;?>/organization/viewEmployeeProfile">View Profile</a></li>
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
                <p>Paris, France</p>
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


<!-- <script>
    document.addEventListener("DOMContentLoaded", () => {
  const stars = document.querySelectorAll("#rating-stars .star");
  const ratingValue = document.getElementById("rating-value");
  let currentRating = 0;

  stars.forEach((star) => {
    // Highlight stars on hover
    star.addEventListener("mouseover", () => {
      resetStars();
      highlightStars(star.dataset.value);
    });

    // Reset stars when not hovering
    star.addEventListener("mouseout", () => {
      resetStars();
      highlightStars(currentRating);
    });

    // Set rating on click
    star.addEventListener("click", () => {
      currentRating = star.dataset.value;
      ratingValue.textContent = `Rating: ${currentRating}`;
      resetStars();
      highlightStars(currentRating);
    });
  });

  function resetStars() {
    stars.forEach((star) => star.classList.remove("hovered", "selected"));
  }

  function highlightStars(rating) {
    stars.forEach((star) => {
      if (star.dataset.value <= rating) {
        star.classList.add(rating == currentRating ? "selected" : "hovered");
      }
    });
  }
});

</script> -->
