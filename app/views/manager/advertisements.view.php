<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/manager.css">
<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/announcements.css"> 

<div class="wrapper flex-row">
    <div id="sidebar" style="width: 224px; height : 100vh; background-color : var(--brand-lavender)">
    
    </div>

    <div class="main-content container">
        <div class="header flex-row">
            <h3>Current Advertisements</h3>
            <button class="btn btn-accent"> + Post Advertisement</button>
        </div>
        <hr>
        
        <div class="search-container">
            <input type="text" 
                class="search-bar" 
                placeholder="Search advertisements"
                aria-label="Search">
        </div>

        <div class="filter flex-row">
            <span>
                <h3>All Ads</h3>
                <p class="text-grey">Showing 73 results</p>
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

        <div class="create-ad-form div-shadow">
            <button class="back"><</button> <p>Create Ad</p>

            <form action="post">
                <div class="form-field">
                    
                </div>
            </form>
        </div>
    </div>

</div>