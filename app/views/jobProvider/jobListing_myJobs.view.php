<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([2]);?>
<?php require APPROOT . '/views/components/navbar.php';
$userID = $_SESSION['user_id'];
$jobModel = $this->model('Job'); 
$jobs = $jobModel->getJobsByUser($userID); 
?>

<link rel="stylesheet" href="<?=ROOT?>/assets/css/jobProvider/jobListing_myJobs.css">

<body>
<div class="wrapper flex-row">
    <?php require APPROOT . '/views/jobProvider/jobProvider_sidebar.php'; ?>
    <div class="inclusion-container">
        <?php require APPROOT . '/views/jobProvider/jobListingOpener.php'; ?>

        <div class="category-container">
        <?php require APPROOT . '/views/jobProvider/categoryLinksJobListing.php'; ?>

        </div> <hr> <br>

        <div class="list-header">
            <p class="list-header-title">My Jobs</p>
            <input type="text" class="search-input" placeholder="Search..."> 
            <button class="filter-btn">Filter</button>
        </div> <br>

        <div class="job-list">
            <?php foreach ($jobs as $job): ?>
                <div class="myjob-item">
                    <div class="job-details">
                        <span class="job-title"><?= $job->jobTitle ?></span>
                        <span class="employment-type"><?= $job->shift ?></span>
                        <span class="duration">Duration: <?= $job->timeFrom ?> - <?= $job->timeTo ?></span>
                        <span class="employment-type">Date: <?= $job->availableDate ?></span>
                    <!--   <span class="myjobs-category">Category: Waiter</span> 
                        <span class="skills">Skills: Diligent, English</span> -->
                        <span class="location">Location: <?= $job->location ?></span>
                        <span class="salary">Salary: <?= $job->salary ?> <?= $job->currency ?>/Hr</span>
                        <span class="employment-type">No. Of Employees: <?= $job->noOfApplicants ?></span>
                        <hr>
                        <span class="employment-type"><?= $job->description ?></span>
                        <hr>
                        <span class="date-posted">Posted on: <?= $job->datePosted ?></span>
                        <span class="time-posted">Posted at: <?= $job->timePosted ?></span>
                        <span class="my-job-id">Job id: #<?= $job->jobID ?></span>

                    </div>
                    <button class="update-jobReq-button btn btn-accent" onClick="window.location.href='<?= ROOT ?>/jobprovider/updateJob/<?= $job->jobID ?>';">Update</button>
                    <button class="delete-jobReq-button btn btn-danger" data-jobid="<?= $job->jobID ?>" onclick="confirmDelete(this)">Delete</button>
                </div>
            <?php endforeach; ?>
        </div>

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
    function confirmDelete(button) {
        var jobId = button.getAttribute('data-jobid');
        var modal = document.getElementById('delete-confirmation');
        modal.style.display = 'flex';

        document.getElementById('confirm-yes').onclick = function() {
            var form = document.getElementById('delete-form');
            form.action = '<?= ROOT ?>/jobProvider/deleteJob/' + jobId;
            modal.style.display = 'none';
            form.submit(); 
        };

        document.getElementById('confirm-no').onclick = function() {
            modal.style.display = 'none';
        };
    }
</script>
</html>