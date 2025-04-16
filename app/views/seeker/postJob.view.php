<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([2]);?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?= ROOT ?>/assets/css/jobProvider/post_job.css">
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/popUpJobForm.css">

<div class="wrapper flex-row">
    <?php require APPROOT . '/views/seeker/seeker_sidebar.php'; ?>

    <div class="main-content container post-job-form">
        <p class="heading">
            Availability
        </p>

        <form class="form-section container" action="<?php echo ROOT ?>/seeker/availability" method="POST">
            <hr>
            <div class="form-section flex-row container">
                <div class="container right-container">
                    <p class="title">
                        Description
                    </p>
                </div>
                <div class="user-input" style="align-items: center; margin-top: 10px;">
                    <textarea name="description" rows="5" cols="30" required></textarea>
                </div>
            </div>
            <hr>
            <div class="form-section flex-row container">
                <div class="container right-container">
                    <p class="title">
                        Type of Employment
                    </p>
                    <p class="text-grey desc">
                        Select One
                    </p>
                </div>
                <div class="user-input" style=" margin-top:10px;">
                    <p class="lbl flex-row" style="gap:10px;justify-content: space-between;">Day time <input type="radio" name="shift" value="Day"> </p><br>
                    <p class="lbl flex-row" style="gap:10px;justify-content: space-between;">Night time<input type="radio" name="shift" value="Night"> </p> <br>
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
                        <input type="text" name="salary" id="salary-per-hr" required>
                        <select id="currency-select" class="currency-select" name="currency">
                            <option value="USD">USD</option>
                            <option value="EUR">EUR</option>
                            <option value="GBP">GBP</option>
                            <option value="LKR">LKR</option>
                            <option value="AUD">AUD</option>
                            <option value="CAD">CAD</option>
                            <option value="JPY">JPY</option>
                            <option value="CNY">CNY</option>
                            <option value="INR">INR</option>
                            <option value="NZD">NZD</option>
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
                            <label for="start-time-select">
                                <p class="lbl">Start Time</p>
                            </label>
                        </div>
                        <div class="input-boxes">
                            <input type="time" id="timeInput" name="timeFrom" required>
                        </div>
                    </div>
                    <div class="end-time flex-col">
                        <div class="label">
                            <label for="end-time-select">
                                <p class="lbl">End Time</p>
                            </label>
                        </div>
                        <div class="input-boxes">
                            <input type="time" id="timeInput" name="timeTo" required>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="form-section flex-row container">
                <div class="container right-container">
                    <p class="title">
                        Date
                    </p>
                    <p class="text-grey desc">
                        Specify the Date for the Job
                    </p>
                </div>
                <div class="user-input flex-col ">
                    <p class="lbl">Date</p>
                    <input type="date" id="dateInput" name="availableDate" required>
                </div>
            </div>
            <hr>
            <div class="form-section flex-row container">
                <div class="container right-container">
                    <p class="title">
                        Tags
                    </p>
                    <p class="text-grey desc">You can add skills, jobs and more</p>
                </div>
                <div class="user-input">
                    <div class="user-input flex-col">
                        <div class="flex-row" style="gap: 20px;">
                            <div class="btn btn-trans" onclick="showAddTagPopup('job')" name="categories">+ Add Categories</div>
                        </div>
                        <div id="tags-container" class="tags-container"></div>
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
                    <input type="text" name="location" placeholder="Type your location">
                </div>
            </div>
            <hr>
            <div class="post-job-buttons flex-row">
                <button class="btn btn-accent" type="button" onclick="window.location.href='<?= ROOT ?>/seeker/jobListing_myJobs'">Discard</button>
                <button class="btn btn-accent" type="submit">Finish</button>
            </div>

            <div id="tag-limit-popup" class="modal" style="display: none;">
                <div class="modal-content">
                    <p>You can only add up to five categories.</p>
                    <button id="popup-ok" class="popup-btn-ok" type="button">Ok</button>
                </div>
            </div>

            <div id="add-tag-popup" class="modal" style="display: none;">
                <div class="modal-content">
                    <p>Enter job category:</p>
                    <input type="text" id="tag-input" class="popup-input">
                    <button id="add-tag-btn" class="popup-btn-add" type="button">Add</button>
                    <button id="cancel-tag-btn" class="popup-btn-cancel" type="button">Cancel</button>
                </div>
            </div>

        </form>

    </div>

</div>

<script>
    function showAddTagPopup(type) {
        const tagContainer = document.getElementById('tags-container');
        if (tagContainer.children.length >= 5) {
            showTagLimitPopup();
            return;
        }

        var modal = document.getElementById('add-tag-popup');
        modal.style.display = 'flex';

        document.getElementById('add-tag-btn').onclick = function() {
            const tagText = document.getElementById('tag-input').value;
            if (tagText) {
                addTag(tagText);
                modal.style.display = 'none';
                document.getElementById('tag-input').value = '';
            }
        };

        document.getElementById('cancel-tag-btn').onclick = function() {
            modal.style.display = 'none';
            document.getElementById('tag-input').value = '';
        };
    }

    function addTag(tagText) {
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

        // Create hidden input to store tag value
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'categories[]';
        hiddenInput.value = tagText;
        tag.appendChild(hiddenInput);
    }

    function showTagLimitPopup() {
        var modal = document.getElementById('tag-limit-popup');
        modal.style.display = 'flex';

        document.getElementById('popup-ok').onclick = function() {
            modal.style.display = 'none';
        };
    }

    // Set today's date as the minimum date
    const today = new Date().toISOString().split("T")[0];
    document.getElementById('availableDate').setAttribute('min', today);

    function submitDate() {
        const selectedDate = document.getElementById('availableDate').value;
        if (selectedDate) {
            alert(`You selected: ${selectedDate}`);
            // Add your submission logic here
        } else {
            alert("Please select a date.");
        }
    }
</script>