<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?=ROOT?>/assets/css/jobProvider/jobListing.css">

<body>
<div class="wrapper flex-row">
    <?php require APPROOT . '/views/jobProvider/jobProvider_sidebar.php'; ?>
    <div class="inclusion-container">
        <div class="opener">
            <p class="title-name">My Jobs</p>
            <button class="post-job-btn">+ Post a job</button>
        </div> <br> <hr>

        <div class="expressionNselect-dates">
            <p class="expression">Here We Go!!!</p>
            <button class="select-dates-btn">Nov 18 - Nov 24</button>
        </div>

        <div class="category-container">
        <?php require APPROOT . '/views/jobProvider/categoryLinksJobListing.php'; ?>

        </div> <hr> <br>

        <div class="list-header">
            <p class="list-header-title">Received History</p>
            <input type="text" class="search-input" placeholder="Search..."> 
            <button class="filter-btn">Filter</button>
        </div> <br>

        <div class="employee-list">
            
            <div class="employee-item">
                <span class="employee-id">1</span>
                <div class="employee-photo">
                    <img src="<?=ROOT?>/assets/images/person1.jpg" alt="Profile Picture">
                </div>
                <div class="employee-details">
                    <span class="employee-name">Nomad Nova</span>
                    <span class="job-title">Bartender</span>
                    <span class="date-applied">24 July 2024</span>
                    <div class="ratings">
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    </div>
                </div>
                <button class="accept-jobReq-button btn btn-accent">Accept</button>
                <button class="reject-jobReq-button btn btn-danger">Reject</button>
                <div class="dropdown">
                    <button class="dropdown-toggle"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                    <ul class="dropdown-menu">
                        <li><a href="#">Message</a></li>
                        <li><a href="#">View Profile</a></li>
                    </ul>
                </div>
            </div>

            <div class="employee-item">
                <span class="employee-id">2</span>
                <div class="employee-photo">
                    <img src="<?=ROOT?>/assets/images/person2.jpg" alt="Profile Picture">
                </div>
                <div class="employee-details">
                    <span class="employee-name">Clara Zue</span>
                    <span class="job-title">Waiter</span>
                    <span class="date-applied">23 July 2024</span>
                    <div class="ratings">
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    </div>
                </div>
                <button class="accept-jobReq-button btn btn-accent">Accept</button>
                <button class="reject-jobReq-button btn btn-danger">Reject</button>
                <div class="dropdown">
                    <button class="dropdown-toggle"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                    <ul class="dropdown-menu">
                        <li><a href="#">Message</a></li>
                        <li><a href="#">View Profile</a></li>
                    </ul>
                </div>
            </div>

            <div class="employee-item">
                <span class="employee-id">3</span>
                <div class="employee-photo">
                    <img src="<?=ROOT?>/assets/images/person3.jpg" alt="Profile Picture">
                </div>
                <div class="employee-details">
                    <span class="employee-name">Kane Smith</span>
                    <span class="job-title">Plumber</span>
                    <span class="date-applied">20 July 2024</span>
                    <div class="ratings">
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    </div>
                </div>
                <button class="accept-jobReq-button btn btn-accent">Accept</button>
                <button class="reject-jobReq-button btn btn-danger">Reject</button>
                <div class="dropdown">
                    <button class="dropdown-toggle"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                    <ul class="dropdown-menu">
                        <li><a href="#">Message</a></li>
                        <li><a href="<?php echo ROOT;?>/jobProvider/viewEmployeeProfile">View Profile</a></li>
                    </ul>
                </div>
            </div>

        </div>

        <div id="popup" class="popup hidden">
            <div class="popup-content">
                <p id="popup-message">Are you sure to accept the request?</p>
                <button id="popup-yes" class="popup-button-jobReq">Yes</button>
                <button id="popup-no" class="popup-button-jobReq">No</button>
            </div>
        </div>

    </div>
</body>
<script>
document.querySelectorAll('.accept-jobReq-button').forEach(button => {
    button.addEventListener('click', () => {
        document.getElementById('popup-message').textContent = 'Are you sure to accept the request?';
        document.getElementById('popup').classList.remove('hidden');
    });
});

document.querySelectorAll('.reject-jobReq-button').forEach(button => {
    button.addEventListener('click', () => {
        document.getElementById('popup-message').textContent = 'Are you sure to reject the request?';
        document.getElementById('popup').classList.remove('hidden');
    });
});

document.getElementById('popup-yes').addEventListener('click', () => {
    document.getElementById('popup').classList.add('hidden');
});

document.getElementById('popup-no').addEventListener('click', () => {
    document.getElementById('popup').classList.add('hidden');
});
</script>
</html>