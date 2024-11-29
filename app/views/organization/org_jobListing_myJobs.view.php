<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([3]);?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?=ROOT?>/assets/css/jobProvider/jobListing_myJobs.css">

<body>
<div class="wrapper flex-row">
    <?php require APPROOT . '/views/jobProvider/organization_sidebar.php'; ?>
    <div class="inclusion-container">
        <?php require APPROOT . '/views/organization/org_jobListingOpener.php'; ?>

        <div class="category-container">
        <?php require APPROOT . '/views/organization/org_categoryLinksJobListing.php'; ?>

        </div> <hr> <br>

        <div class="list-header">
            <p class="list-header-title">My Jobs</p>
            <input type="text" class="search-input" placeholder="Search..."> 
            <button class="filter-btn">Filter</button>
        </div> <br>

        <div class="job-list">
            
            <div class="myjob-item">
            <div class="job-details">
                    <span class="job-title">Fruit Picker for a apple farm</span>
                    <span class="employment-type">Night-time</span>
                    <span class="duration">Duration: 06:00 PM - 01:30 AM</span>
                    <span class="myjobs-category">Category: Waiter</span>
                    <span class="skills">Skills: Diligent, English</span>
                    <span class="location">Location: Dehiwala-Mount Lavinia</span>
                    <span class="salary">Salary: 13.50$ per hour</span>
                    <hr>
                    <span class="date-posted">Posted on: 2024-11-26</span>
                    <span class="time-posted">Posted at: 03:37 PM</span>
                    <span class="my-job-id">Job id: #1</span>

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
</script>
</html>