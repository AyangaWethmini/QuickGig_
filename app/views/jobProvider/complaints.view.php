<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>
<link rel="stylesheet" href="<?=ROOT?>/assets/css/user/complaints.css">

<div class="wrapper flex-row">
    <?php require APPROOT . '/views/jobProvider/jobProvider_sidebar.php'; ?>
    
    <div class="main-content-complaints">
        <div class="header">
            <div class="heading">My Complaints</div>
        </div>
        <hr>
        <div class="search-container">
            <input type="text" 
                class="search-bar" 
                placeholder="Search complaints"
                aria-label="Search">
            <br><br>
            <div class="filter-container">
                <span>Sort by:</span>
                <select id="sortSelect" onchange="sortContent()">
                    <option value="recent">Latest</option>
                    <option value="views">Oldest</option>
                </select>
            </div>
        </div>
        <div class="complaints-container container">
        <?php foreach($data['complaints'] as $complaint): ?>
            <div class="complaint container">
                <div class="complaint-content flex-col">
                    <div class="complaint-details flex-row">
                        <div class="complaint-text flex-col">
                            <div class="the-complaint"><?php echo $complaint->content ?></div>   
                            <div class="text-grey"><?php echo $complaint->complaintDate ?> | <?php echo $complaint->complaintTime ?></div>
                        </div>
                        <div class="complaint-status">Pending</div>
                    </div>
                    <div class="complaint-actions flex-row">
                        <button class="btn btn-update">Update</button>
                        <button class="btn btn-delete">Delete</button>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
        </div>
    </div>
</div>