<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?= ROOT ?>/assets/css/jobProvider/post_job.css">

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
                    <textarea name="description" rows="5" cols="30"></textarea>
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
                    <p class="lbl flex-row" style="gap:10px;justify-content: space-between;">Daytime <input type="radio" name="shift"> </p><br>
                    <p class="lbl flex-row" style="gap:10px;justify-content: space-between;">Night time<input type="radio" name="shift"> </p> <br>
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
                        <input type="text" name="salary" id="salary-per-hr">
                        <select id="currency-select" class="currency-select" name="currency">
                            <option value="USD">USD</option>
                            <option value="EUR">EUR</option>
                            <option value="GBP">GBP</option>
                            <option value="LKR">LKR</option>
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
                    <button type="button" class="btn btn-trans" onclick="submitDate()">Submit</button>
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
                    <div class="user-input flex-col">
                        <div class="flex-row" style="gap: 20px;">
                            <div class="btn btn-trans" onclick="addTag('job')" name="categories">+ Add Categories</div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>

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
                    <input type="text" name="location" placeholder="Add location using google maps">
                </div>
            </div>
            <hr>
            <div class="post-job-buttons flex-row">
                <button class="btn btn-accent">Discard</button>
                <button class="btn btn-accent" type="submit">Finish</button>
            </div>
    </div>
    </form>

</div>

</div>

<script>
    function addTag(type) {
        const tagText = prompt(`Enter ${type === 'job' ? 'job' : 'Language'}`);
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