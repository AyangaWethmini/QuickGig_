<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager.css"> 

<div class=" wrapper flex-row">
    <div id="sidebar" style="width: 224px; height : 100vh; background-color : var(--brand-lavender)">
    
    </div>
    
    <div class="main-content  container">
        <div class="header flex-row">
            <span class="greeting container">
            <h3>Good morning! Maria</h3>
            <p class="text-grey">Here is the statistics from 12th July - 12th August</p>
            </span>
            <span class="date">
                <p>Jul12-Aug12</p>
            </span>
        </div>
        <div class="overview flex-row">
            <div class="flex-row box container">
                <h1>23</h1>
                <p>Ads posted</p>    
            </div>
            <div class="flex-row box container">
                <h1>23</h1>
                <p>Ads posted</p> 
            </div>
            <div class="flex-row box container">
                <h1>23</h1>
                <p>Ads posted</p> 
            </div>
            <div class="flex-row box container">
                <h1>23</h1>
                <p>Ads posted</p> 
            </div>
        </div>
        <hr>
        <div class="manager-sections flex-row">
            <div class="chart-overview">

            </div>
            <div class="messages">

            </div>
        </div>
        <div class="flex-row">
            <button class="btn btn-accent">Post Advertisement</button>
            <button class="btn btn-accent">Review Ads</button>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>

 
    