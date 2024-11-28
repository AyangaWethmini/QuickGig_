<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?= ROOT ?>/assets/css/jobProvider/jobListing_myJobs.css">

<body>
    <div class="wrapper flex-row">
        <?php require APPROOT . '/views/seeker/seeker_sidebar.php'; ?>
        <div class="inclusion-container">
            <?php require APPROOT . '/views/seeker/jobListingOpener.php'; ?>

            <div class="category-container">
                <?php require APPROOT . '/views/seeker/categoryLinksJobListing.php'; ?>

            </div>
            <hr> <br>

            <div class="list-header">
                <p class="list-header-title">My Jobs</p>
                <input type="text" class="search-input" placeholder="Search...">
                <button class="filter-btn">Filter</button>
            </div> <br>

            <div class="job-list">

                <div class="myjob-item">
                    <div class="job-details">
                        <span class="job-title"><?= htmlspecialchars($job->description) ?></span>
                        <span class="employment-type"><?= htmlspecialchars($job->shift) ?></span>
                        <span class="duration">Duration: <?= htmlspecialchars($job->timeFrom) ?> - <?= htmlspecialchars($job->timeTo) ?></span>
                        <span class="myjobs-category">Category: <?= htmlspecialchars($job->category ?? 'N/A') ?></span>
                        <span class="skills">Skills: <?= htmlspecialchars($job->skills ?? 'N/A') ?></span>
                        <span class="location">Location: <?= htmlspecialchars($job->location) ?></span>
                        <span class="salary">Salary: <?= htmlspecialchars($job->salary) ?> <?= htmlspecialchars($job->currency) ?> per hour</span>
                        <hr>
                        <span class="date-posted">Posted on: <?= htmlspecialchars($job->availableDate) ?></span>
                        <span class="time-posted">Posted at: <?= htmlspecialchars($job->timeFrom) ?></span>
                        <span class="my-job-id">Job id: #<?= htmlspecialchars($job->availableID) ?></span>

                    </div>
                    <button class="update-jobReq-button btn btn-accent">Update</button>
                    <button class="delete-jobReq-button btn btn-danger">Delete</button>
                </div>

            </div>

            <div id="popup" class="popup hidden">
                <div class="popup-content">
                    <p id="popup-message">Are you sure you want to delete this job?</p>
                    <button id="popup-yes" class="popup-button-jobReq">Yes</button>
                    <button id="popup-no" class="popup-button-jobReq">No</button>
                </div>
            </div>

        </div>
</body>
<script>
    document.querySelectorAll('.delete-jobReq-button').forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('popup-message').textContent = 'Are you sure you want to delete this job?';
            document.getElementById('popup').classList.remove('hidden');
        });
    });

    document.getElementById('popup-yes').addEventListener('click', () => {
        document.getElementById('popup').classList.add('hidden');
        // Add your delete logic here
    });

    document.getElementById('popup-no').addEventListener('click', () => {
        document.getElementById('popup').classList.add('hidden');
    });
    document.querySelectorAll('.delete-jobReq-button').forEach(button => {
        button.addEventListener('click', (event) => {
            const jobId = event.target.dataset.id;
            document.getElementById('popup-message').textContent = `Are you sure you want to delete job ID #${jobId}?`;
            document.getElementById('popup').classList.remove('hidden');

            // Add logic to delete the job
            document.getElementById('popup-yes').addEventListener('click', () => {
                fetch(`<?= ROOT ?>/seeker/deleteJob/${jobId}`, { method: 'DELETE' })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload(); // Refresh the page after deletion
                        } else {
                            alert('Failed to delete the job.');
                        }
                    });
                document.getElementById('popup').classList.add('hidden');
            });

            document.getElementById('popup-no').addEventListener('click', () => {
                document.getElementById('popup').classList.add('hidden');
            });
        });
    });
</script>

</html>