<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([1]); ?>
<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/manager.css">
<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/advertisements.css"> 
<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/announcements.css"> 
<?php include APPROOT . '/views/components/navbar.php'; ?>


<div class="wrapper flex-row" style="margin-top: 100px;">

    <?php require APPROOT . '/views/manager/manager_sidebar.php'; ?>

    <div class="main-content container">
        <div>
        <div class="header flex-col">
            <h2>Announcements</h2>
            <hr>
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
                        <textarea name="content" required style="width: 400px; height: 150px;"></textarea>
                    </div>
                    <button type="submit" class="btn btn-accent">Create Announcement</button>
                </form>
            </div>
            <div class="flex-col">
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

                    <?php if (!empty($announcements) && (is_array($announcements) || is_object($announcements))): ?>
                        <?php foreach ($announcements as $announcement): ?>
                            <div class="announcement-card flex-col container">
                                <h3>Announcement ID : <?=htmlspecialchars(($announcement->announcementID))?></h3>
                                <p><?=htmlspecialchars(($announcement->content))?></p>
                                <div class="date-time"><?=htmlspecialchars(($announcement->announcementDate))?> @ <?=htmlspecialchars(($announcement->announcementTime))?></div>
                            </div>
                            <br>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No announcments Yet!</p>
                    <?php endif; ?>

                
                </div>

                <?php
            include_once APPROOT . '/views/components/alertBox.php';
            if (isset($_SESSION['error'])) {
                echo '<script>showAlert("' . htmlspecialchars($_SESSION['error']) . '", "error");</script>';
            }
            if (isset($_SESSION['success'])) {
                echo '<script>showAlert("' . htmlspecialchars($_SESSION['success']) . '", "success");</script>';
            }
            unset($_SESSION['error']);
            unset($_SESSION['success']);
        ?>

            
        </div>

                

                

                

                
            </div>
        </div>
    </div>
</div>
        

