<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/manager.css">
<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/advertisements.css"> 

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

        <div class="create-ad-form from" style="background-color: yellow;">
            <button class="back"><</button> <p>Create Ad</p>

            <form action="post">
                <div class="form-field">
                    <lable class="lbl">Name</lable><br>
                    <input type="text" for="name">
                </div>
                <div class="form-field">
                    <lable class="lbl">Advertiser</lable><br>
                    <input type="text" for="name">
                </div>
                <div class="form-field">
                    <lable class="lbl">Advertiser contact no.</lable><br>
                    <input type="text" for="name">
                </div>
                <div class="form-field">
                    <lable class="lbl">Description</lable><br>
                    <textarea id="description" name="description" rows="4" ></textarea>
                </div>
                <div class="form-field">
                    <lable class="lbl">Category</lable><br>
                    <input type="text" for="name">
                </div>
                <div class="form-field">
                    <lable class="lbl">Expiry date</lable><br>
                    <input type="text" for="name">
                </div>
                <div class="form-field">
                    <lable class="lbl">Tages</lable><br>
                    <input type="text" for="name">
                </div>
                <div class="form-field">
                    <input type="radio" name="paid"><label for="paid">Paid</label>
                    <input type="radio" name="pending"><label for="pending">Pending</label>
                </div>
                <div class="form-field">
                    <a href="#">Add Image</a>
                </div>
                <button class="btn btn-accent">Post Ad</button>
            </form>
        </div>
    </div>

</div>

