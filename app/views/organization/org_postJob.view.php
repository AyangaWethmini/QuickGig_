<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?=ROOT?>/assets/css/jobProvider/post_job.css">

<div class="wrapper flex-row">
    <?php require APPROOT . '/views/jobProvider/organization_sidebar.php'; ?>

    <div class="main-content container post-job-form">
        <p class="heading">
            Post a Job
        </p>

        <div class="form-section container">
            <div class="container right-container">
                <p class="title">
                    Basic Information
                </p>
                <p class="text-grey desc">This information will be displayed publicly</p>
            </div>
        </div>
        <hr>
        <div class="form-section flex-row container">
            <div class="container right-container">
                <p class="title">
                    Job Title
                </p>
                <p class="text-grey  desc">Explain the kind of job you are offering</p>
            </div>
            <div class="user-input">
                <input type="text" placeholder="e.g., Babysitter"  id="job-title">
            </div>
        </div>
        <hr>
        <div class="form-section flex-row container">
            <div class="container right-container">
                <p class="title">
                    Type of Employment
                </p>
                <p class="text-grey desc">
                    You can select multiple types of employment
                </p>
            </div>
            <div class="user-input">
                <p class="lbl">Daytime <input type="checkbox"> </p><br>
                <p class="lbl">Night time<input type="checkbox"> </p> <br>
            </div>
        </div>
        <hr>
        <div class="form-section flex-row container">
            <div class="container right-container">
                <p class="title">
                    Salary (Per hour)
                </p>
                <p class="text-grey desc">
                    Please set the estimated salary range for the role.
                </p>
            </div>
            <div class="user-input">
                <div class="salary-ph flex-row">
                    <input type="text" id="salary-per-hr">
                    <select id="currency-select" class="currency-select">
                        <option value="USD">USD</option>
                        <option value="EUR">EUR</option>
                        <option value="GBP">GBP</option>
                        <option value="LKR">LKR</option>
                        <!-- Add more currencies as needed -->
                    </select>
                </div>
            </div>
        </div>
        <hr>
        <div class="form-section flex-row container">
            <div class="container right-container">
                <p class="title">
                    Duration
                </p>
                <p class="text-grey desc">
                    Specify the start and end time for the job.
                </p>
            </div>
            <div class="user-input duration flex-row">
                <div class="start-time flex-col">
                    <div class="label">
                        <label for="start-time-select"><p class="lbl">Start Time</p></label>
                    </div>
                    <div class="input-boxes">
                        <select id="start-time-select" class="time-select"></select>
                        <select id="start-ampm-select" class="am-pm">
                            <option value="AM">AM</option>
                            <option value="PM">PM</option>
                        </select>
                    </div>
                </div>
                <div class="end-time flex-col">
                    <div class="label">
                        <label for="end-time-select"><p class="lbl">End Time</p></label>
                    </div>
                    <div class="input-boxes">
                        <select id="end-time-select" class="time-select"></select>
                        <select id="end-ampm-select" class="am-pm">
                            <option value="AM">AM</option>
                            <option value="PM">PM</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="form-section flex-row container">
            <div class="container right-container">
                <p class="title">
                 Categories
                </p>
                <p class="text-grey desc">You can select multiple job categories</p>
            </div>
            <div class="user-input">
                <div class="dropdown">
                    <select>
                        <option>Select Job Categories</option>
                        <option>Design</option>
                        <option>Development</option>
                        <option>Marketing</option>
                        <!-- Add more categories as needed --> 
                    </select>
                </div>
            </div>
        </div>
        <hr>
        <div class="form-section flex-row container">
            <div class="container right-container">
                <p class="title">
                Required Skills
                </p>
                <p class="text-grey desc">Add required skills for the job</p>
            </div>
            <div class="user-input flex-col">
                <div class="flex-row" style="gap: 20px;">
                <div class="btn btn-trans" onclick="addTag('skill')">+ Add Skills</div>
                <div class="btn btn-trans" onclick="addTag('language')">+ Add Languages</div>
                </div>
                <div class="tags-container" id="tags-container">
                    <!-- Dynamic tags will appear here -->
                </div>
            </div>
        </div>
        <hr>
        <div class="form-section flex-row container">
            <div class="container right-container">
                <p class="title">
                Add Location
                </p>
                <p class="text-grey desc">Add the location where the employee should attend</p>
            </div>
            <div class="user-input">
                <button class="btn btn-trans">Add your Location</button>
                <p>Or</p>
                <input type="text" for="Location" placeholder="Add location using google maps">
                </div>
            </div>
            <hr>
            <div class="post-job-buttons flex-row">
                <button class="btn btn-accent">Discard</button>
                <button class="btn btn-accent">Finish</button>
            </div>
        </div>
        
    </div>
        
</div>

<script>
  // Function to populate time dropdowns
  function populateTimeDropdown(selectElement) {
    for (let hour = 1; hour <= 12; hour++) {
      for (let minutes = 0; minutes < 60; minutes += 30) {
        const time = `${hour}:${String(minutes).padStart(2, '0')}`;
        const option = document.createElement('option');
        option.value = time;
        option.textContent = time;
        selectElement.appendChild(option);
      }
    }
  }

  // Select elements for start and end times
  const startTimeSelect = document.getElementById('start-time-select');
  const endTimeSelect = document.getElementById('end-time-select');

  // Populate both dropdowns
  populateTimeDropdown(startTimeSelect);
  populateTimeDropdown(endTimeSelect);

  function addTag(type) {
        const tagText = prompt(`Enter ${type === 'skill' ? 'Skill' : 'Language'}`);
        if (tagText) {
            const tagContainer = document.getElementById('tags-container');
            
            // Create tag element
            const tag = document.createElement('div');
            tag.className = 'tag';
            tag.textContent = tagText;
            
            // Add remove button
            const removeBtn = document.createElement('span');
            removeBtn.className = 'remove-btn';
            removeBtn.textContent = '×';
            removeBtn.onclick = () => tag.remove();
            
            // Append remove button to tag
            tag.appendChild(removeBtn);
            
            // Append tag to container
            tagContainer.appendChild(tag);
        }
    }

</script>