<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>
<link rel="stylesheet" href="<?=ROOT?>/assets/css/user/complaints.css">

<div class="wrapper flex-row">
    <?php require APPROOT . '/views/seeker/seeker_sidebar.php'; ?>
    
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
        
                <div class="complaint container">
                    <div class="complaint-content flex-col">
                        <div class="complaint-details flex-row">
                            <div class="complaint-text flex-col">
                                <div class="the-complaint">He wasn't at home when I went there. I had to wait about 20 minutes. He refused to pay the agreed amount of money. Had to debate for while.</div>   
                                <div class="text-grey">
                                    2021-11-21 | 12:00 PM
                                </div>
                            </div>
                            <div class="complaint-status">Pending</div>
                        </div>
                        <div class="complaint-actions flex-row">
                            <button class="btn btn-update">Update</button>
                            <button class="btn btn-delete" onclick="confirmDelete()">Delete</button>
                        </div>
                    </div>
                </div>
            
        </div>
    </div>
</div>

<div id="delete-confirmation" class="modal" style="display: none;">
    <div class="modal-content">
        <p>Are you sure you want to delete this complaint?</p>
        <button id="confirm-yes" class="popup-btn-delete-complaint">Yes</button>
        <button id="confirm-no" class="popup-btn-delete-complaint">No</button>
    </div>
</div>



<script>
function confirmDelete() {
    var modal = document.getElementById('delete-confirmation');
    modal.style.display = 'flex';

    document.getElementById('confirm-yes').onclick = function() {
        
        modal.style.display = 'none';

    
    };

    document.getElementById('confirm-no').onclick = function() {
        modal.style.display = 'none';
    };
}
</script>