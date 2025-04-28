<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([2]);?>
<?php require APPROOT . '/views/components/navbar.php'; 
$userID = $_SESSION['user_id'];
$availableModel = $this->model('Available'); 
$jobs = $availableModel->getJobsByUser($userID); 
?>

<link rel="stylesheet" href="<?= ROOT ?>/assets/css/jobProvider/jobListing_myJobs.css">
<link rel="stylesheet" href="<?=ROOT?>/assets/css/components/empty.css">

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
                <form method="GET" action="<?= ROOT ?>/seeker/jobListing_myJobs">
                    <input type="text" name="search" class="search-input" placeholder="Search..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                </form>
                <input 
                type="date" 
                id="filter-date" 
                class="filter-btn" 
                onchange="filterByDate(this.value)" 
                style="appearance: none; padding: 10px 15px; border: 1px solid #ccc; border-radius: 5px; background-color: #f8f9fa; cursor: pointer; font-size: 16px;"
            />
            </div> 
            <br>

            <div class="job-list">
                <?php if (!empty($data['jobs'])): ?>
                <?php foreach ($jobs as $job): 
                    $categories = json_decode($job->categories, true);
                    $categoriesString = is_array($categories) ? implode(', ', $categories) : 'N/A';
                    $jobStatusClass = ($job->availabilityStatus == 2) ? 'inactive-job' : '';
                ?>
                    <div class="myjob-item <?= $jobStatusClass ?>">
                        <div class="job-details">
                            <span class="job-title"><?= htmlspecialchars($job->description) ?></span>
                            <span class="employment-type">Shift: <?= htmlspecialchars($job->shift) ?></span>
                            <span class="duration">Duration: <?= htmlspecialchars($job->timeFrom) ?> - <?= htmlspecialchars($job->timeTo) ?></span>
                            <span class="employment-type">Date: <?= htmlspecialchars($job->availableDate) ?></span>
                            <span class="myjobs-category">Tags: <?= htmlspecialchars($categoriesString) ?></span>
                            <span class="location">Location: <?= htmlspecialchars($job->location) ?></span>
                            <span class="salary">Salary: <?= htmlspecialchars($job->salary) ?> <?= htmlspecialchars($job->currency) ?>/Hr</span>
                            <hr>
                            <span class="date-posted">Posted on: <?= htmlspecialchars($job->datePosted) ?></span>
                            <span class="time-posted">Posted at: <?= htmlspecialchars($job->timePosted) ?></span>
                            <span class="my-job-id">Job id: #<?= htmlspecialchars($job->availableID) ?></span>
                        </div>
                        <button class="update-jobReq-button btn btn-accent" onClick="window.location.href='<?= ROOT ?>/seeker/updateAvailability/<?= $job->availableID ?>';">Update</button>
                        <button class="delete-jobReq-button btn btn-danger" data-jobid="<?= $job->availableID ?>" onclick="confirmDelete(this)">Delete</button>
                    </div>
                <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-container">
                        <img src="<?=ROOT?>/assets/images/no-data.png" alt="No Availabilities" class="empty-icon">
                        <p class="empty-text">No Availabilities Have Been Listed</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Delete Confirmation Modal -->
            <div id="delete-confirmation" class="modal" style="display: none;">
                <div class="modal-content">
                    <p>Are you sure you want to delete this job?</p>
                    <button id="confirm-yes" class="popup-btn-delete-complaint">Yes</button>
                    <button id="confirm-no" class="popup-btn-delete-complaint">No</button>
                </div>
            </div>

            <form id="delete-form" method="POST" style="display: none;"></form>

        </div>
    </div>

</body>

<script>
    // Open modal and set the job id for deletion
    function confirmDelete(button) {
        var jobId = button.getAttribute('data-jobid'); // Get the job ID from the clicked button
        var modal = document.getElementById('delete-confirmation');
        modal.style.display = 'flex'; // Show modal

        // Handle the Yes button
        document.getElementById('confirm-yes').onclick = function() {
            var form = document.getElementById('delete-form');
            form.action = '<?= ROOT ?>/seeker/deleteAvailability/' + jobId; // Set the form action URL
            modal.style.display = 'none'; // Hide modal
            form.submit(); // Submit the form
        };

        // Handle the No button
        document.getElementById('confirm-no').onclick = function() {
            modal.style.display = 'none'; // Hide modal
        };
    }

    document.querySelector('.search-input').addEventListener('input', function () {
        const searchTerm = this.value;

        fetch(`<?= ROOT ?>/seeker/jobListing_myJobs?search=${encodeURIComponent(searchTerm)}`)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContent = doc.querySelector('.job-list').innerHTML;
                document.querySelector('.job-list').innerHTML = newContent;
            })
            .catch(error => console.error('Error:', error));
    });
</script>

</html>