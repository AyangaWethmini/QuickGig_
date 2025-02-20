<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php'; 
protectRoute([0]);?>
<link rel="stylesheet" href="<?php echo ROOT; ?>/assets/css/admin/admin_announcement.css">
<?php include APPROOT . '/views/components/navbar.php'; ?>

<div class="admin-layout">
    <?php require APPROOT . '/views/components/admin_sidebar.php'; ?>
    <div class="admin-container">
        <div class="admin-announcement-header">
            <h1>Current Complaints</h1>
        </div>
        <br>
        <hr><br>
        <div class="admin-announcement-searchbar">
            <input type="search" name="query" placeholder="Search Complaints">
        </div>
        <div class="admin-announcement-filterheader">
            <h1>All Complaints</h1>
        </div>
        <div class="complaints-container container">
            <?php foreach ($data['complaints'] as $complaint): ?>
                <div class="complaint container">
                    <div class="complaint-details flex-col">
                        <div class="complaint-details flex-row">
                            <div class="the-complaint"><?php echo $complaint->content ?></div>
                            <div class="the-complaint"><?php echo $complaint->complainantID ?></div>
                            <div class="text-grey">
                                <?php
                                $formattedTime = date('h:i A', strtotime($complaint->complaintTime));
                                echo $complaint->complaintDate . ' | ' . $formattedTime;
                                ?>
                            </div>
                        </div>
                        <div class="complaint-status">
                            <select
                                name="status"
                                class="status-dropdown"
                                data-complaint-id="<?php echo $complaint->complaintID; ?>" onchange="updateComplaintStatus(this)">
                                <option value="1" <?php echo $complaint->complaintStatus === 1 ? 'selected' : ''; ?>>Pending</option>
                                <option value="2" <?php echo $complaint->complaintStatus === 2 ? 'selected' : ''; ?>>Under Reviewed</option>
                                <option value="3" <?php echo $complaint->complaintStatus === 3 ? 'selected' : ''; ?>>Reviewed</option>
                            </select>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

</div>

<script>
    function updateComplaintStatus(selectElement) {
        const complaintId = selectElement.dataset.complaintId; // Get the complaint ID
        console.log(complaintId);
        const newStatus = selectElement.value; // Get the selected status value

        // Send an AJAX request to update the status
        fetch('<?php echo ROOT; ?>/admin/updateComplaintStatus', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: complaintId,
                    status: newStatus
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Complaint ID:', complaintId);
                    console.log('New Status:', newStatus);
                    // alert('Complaint status updated successfully!');
                } else {
                    alert('Failed to update complaint status.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating the complaint status.');
            });
    }
</script>


<?php require APPROOT . '/views/inc/footer.php'; ?>