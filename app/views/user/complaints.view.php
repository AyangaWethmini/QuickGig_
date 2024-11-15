<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?=ROOT?>/assets/css/user/complaints.css">

<div class="wrapper flex-row">
    <div id="sidebar" style="width: 224px; height : 100vh; background-color : var(--brand-lavender)">
    
    </div>
    
    <div class="main-content container">
    <div class="header">
        <h1 class="heading">Complaints</h1>
    </div>
    <hr>
    <div class="search-container">
        <input type="text" 
                        class="search-bar" 
                        placeholder="Search complaints"
                        aria-label="Search">
    </div>
    <div class="filter flex-row">
            <span>
                <h3>My Complaints</h3>
                <p class="text-grey">Showing 2 results</p>
            </span>

            <div class="filter-container">
                <span>Sort by:</span>
                <select id="sortSelect" onchange="sortContent()">
                    <option value="recent">Most recent</option>
                    <option value="views">Highest views</option>
                </select>
                <button id="gridButton" onclick="toggleView()">☰</button>
            </div>
    </div>
    <div class="complaints-container container">
        <div class="complaint container">
            <h1>Did not pay the agreed amount</h1> 
            <p class="text-grey">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Neque, at corrupti? Atque, quam nemo. Ratione repellendus, animi distinctio incidunt fugit tempore quasi necessitatibus ipsum, neque reprehenderit maxime minima. Temporibus excepturi ipsum, nam sequi odio nobis maiores exercitationem odit delectus qui.,</p>   
            <div class="details flex-row">
                <p class="text-grey">User12345 | 2024/09/07 | 3.57p.m.</p>
                <button class="btn btn-accent"> Pending </button>
            </div>    
        </div>
            
        <div class="complaint container">
        <h1>Did not pay the agreed amount</h1>
        <p class="text-grey"> Lorem ipsum dolor, sit amet consectetur adipisicing elit. Neque, at corrupti? Atque, quam nemo. Ratione repellendus, animi distinctio incidunt fugit tempore quasi necessitatibus ipsum, neque reprehenderit maxime minima. Temporibus excepturi ipsum, nam sequi odio nobis maiores exercitationem odit delectus qui.,</p>
        <div class="details flex-row">
                <p class="text-grey">User12345 | 2024/09/07 | 3.57p.m.</p>
                <button class="btn btn-accent"> Pending </button>
        </div>
        </div>
    </div>
</div>