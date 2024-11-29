<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([1]);?>
<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/manager.css">
<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/advertisements.css"> 
<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/announcements.css"> 
<?php include APPROOT . '/views/components/navbar.php'; ?>


<div class="wrapper flex-row" style="margin-top: 100px;">

    <?php require APPROOT . '/views/manager/manager_sidebar.php'; ?>

    <div class="main-content container">
        <div class="header flex-row">
            <h3>Announcements</h3>
        </div>
        <hr>
        
        <div class="search-container">
            <input type="text" 
                class="search-bar" 
                placeholder="Search announcements"
                aria-label="Search">
        </div>

        
        <br><br>

        <div class="announcements container flex-row">
            <div class="create-announcement-form container flex-col">
                <h3>Create Announcement</h3>
                <form action="" method="POST">
                    <div class="form-field">
                        <label class="lbl">Title</label><br>
                        <input type="text" name="title" required style="width: 400px; padding: 0px;">
                    </div>
                    
                    <div class="form-field">    
                        <label class="lbl">Content</label><br>
                        <textarea name="content" width="400px" height="150px" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-accent">Create Announcement</button>
                </form>
                
            </div>
            <div class="announcements container flex-col">
            <div class="filter flex-row">
            <span>
                <h3>All Announcements</h3>
                <p class="text-grey">Showing 0 results</p>
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

        <br><br>
                <div class="announcement-card flex-col container">
                    <h3>Announcement Title</h3>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Odit harum ducimus mollitia, voluptatum fugit laboriosam provident amet necessitatibus consectetur, deleniti expedita sequi consequatur, perferendis dolorum!</p>
                    <div class="date-time">2024. 04. 04 @ 12:00</div>
                </div>

                <div class="announcement-card flex-col container">
                    <h3>Announcement Title</h3>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Odit harum ducimus mollitia, voluptatum fugit laboriosam provident amet necessitatibus consectetur, deleniti expedita sequi consequatur, perferendis dolorum!</p>
                    <div class="date-time">2024. 04. 04 @ 12:00</div>
                </div>

                <div class="announcement-card flex-col container">
                    <h3>Announcement Title</h3>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Odit harum ducimus mollitia, voluptatum fugit laboriosam provident amet necessitatibus consectetur, deleniti expedita sequi consequatur, perferendis dolorum!</p>
                    <div class="date-time">2024. 04. 04 @ 12:00</div>
                </div>
            </div>

</div>
        

