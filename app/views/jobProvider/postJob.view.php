<?php require APPROOT . '/views/inc/header.php'; ?>

<link rel="stylesheet" href="<?=ROOT?>/assets/css/jobProvider/post_job.css">

<div class="wrapper flex-row">
    <div id="sidebar" style="width: 224px; height : 100vh; background-color : var(--brand-lavender)">
    
    </div>

    <div class="main-content container post-job-form">
        <p class="heading">
            <i class="fa-solid fa-arrow-left"></i> Post a Job
        </p>

        <div class="form-section container">
            <div class="container">
                <p class="title">
                    Basic Information
                </p>
                <p class="text-grey">This onfrmation will be displayed publically</p>
            </div>
        </div>
        <hr>
        <div class="form-section flex-row container">
            <div class="container">
                <p class="title">
                    Job Title
                </p>
                <p class="text-grey">Explain the kind of the job you are offering</p>
            </div>
            <div class="user-input">
                <input type="text" placeholder="e.g : Baby sitter">
            </div>
        </div>
        <hr>
        <div class="form-section flex-row container">
            <div class="container">
                <p class="title">
                    Type of employment
                </p>
                <p class="text-grey">
                    You can select multiple type of employments
                </p>
            </div>
            <div class="user-input">
                <input type="checkbox">Daytime <br>
                <input type="checkbox">Night time <br>
                <input type="checkbox">Weekend <br>
            </div>
        </div>
        <hr>
        <div class="form-section flex-row container">
            <div class="container">
                <p class="title">
                    Salery
                </p>
                <p class="text-grey">
                    You can select multiple type of employments
                </p>
            </div>
            <div class="user-input">
                <input type="checkbox">Daytime <br>
                <input type="checkbox">Night time <br>
                <input type="checkbox">Weekend <br>
            </div>
        </div>
    </div>

</div>