<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php';
protectRoute([0]); ?>
<link rel="stylesheet" href="<?php echo ROOT; ?>/assets/css/admin/admin_announcement.css">
<?php include APPROOT . '/views/components/navbar.php'; ?>

<div class="admin-layout">
    <?php require APPROOT . '/views/components/admin_sidebar.php'; ?>
    <div class="admin-container">
        <div class="admin-announcement-filterheader">
            <h1>All Complaints</h1>
            <div class="tabs">
                <button class="tab-btn active" onclick="showTab('pending')">Pending</button>
                <button class="tab-btn" onclick="showTab('reviewed')">Reviewed</button>
            </div>
        </div>

        <div id="pending-complaints" class="complaints-container container tab-content active">
            <?php foreach ($data['complaints'] as $complaint): ?>
                <?php if ($complaint->complaintStatus === 1): ?>
                    <div class="complaint container" onclick="showComplaintPopup('<?php echo $complaint->complaintID ?>')">
                        <div class="complaint-details flex-col">
                            <div class="complaint-details flex-row">
                                <div class="the-complaint"><?php echo $complaint->content ?></div>
                                <div class="text-grey">
                                    <?php
                                    $formattedTime = date('h:i A', strtotime($complaint->complaintTime));
                                    echo $complaint->complaintDate . ' | ' . $formattedTime;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <div id="reviewed-complaints" class="complaints-container container tab-content">
            <?php foreach ($data['complaints'] as $complaint): ?>
                <?php if ($complaint->complaintStatus === 3): ?>
                    <div class="complaint container">
                        <div class="complaint-details flex-col">
                            <div class="complaint-details flex-row">
                                <div class="the-complaint"><?php echo $complaint->content ?></div>
                                <div class="text-grey">
                                    <?php
                                    $formattedTime = date('h:i A', strtotime($complaint->complaintTime));
                                    echo $complaint->complaintDate . ' | ' . $formattedTime;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <!-- Complaint Popup -->
        <div id="complaintPopup" class="popup">
            <div class="popup-content">
                <span class="close-popup" onclick="closePopup()">&times;</span>
                <h2>Complaint Details</h2>
                <div id="popupContent"></div>
                <div class="popup-buttons">
                    <button onclick="markAsReviewed()" class="review-btn">Mark as Reviewed</button>
                    <button onclick="dismissComplaint()" class="dismiss-btn">Dismiss</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .tabs {
        margin-bottom: 20px;
    }

    .tab-btn {
        padding: 10px 20px;
        margin-right: 10px;
        border: none;
        background-color: #f0f0f0;
        cursor: pointer;
    }

    .tab-btn.active {
        background-color: #007bff;
        color: white;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    .popup {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
    }

    .popup-content {
        position: relative;
        background-color: white;
        margin: 15% auto;
        padding: 20px;
        width: 70%;
        max-width: 600px;
        border-radius: 5px;
    }

    .close-popup {
        position: absolute;
        right: 10px;
        top: 10px;
        font-size: 24px;
        cursor: pointer;
    }

    .review-btn {
        margin-top: 20px;
        padding: 10px 20px;
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .popup-buttons {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .dismiss-btn {
        padding: 10px 20px;
        background-color: #dc3545;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .review-btn,
    .dismiss-btn {
        flex: 1;
    }
</style>

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

    function showTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.remove('active');
        });

        // Remove active class from all buttons
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active');
        });

        // Show selected tab content and activate button
        document.getElementById(tabName + '-complaints').classList.add('active');
        event.target.classList.add('active');
    }

    function showComplaintPopup(complaintId) {
        // Fetch complaint details including user emails using AJAX
        fetch(`<?php echo ROOT ?>/admin/getComplaintDetails/${complaintId}`)
            .then(response => response.json())
            .then(data => {
                const popup = document.getElementById('complaintPopup');
                const content = document.getElementById('popupContent');

                content.innerHTML = `
                <p><strong>Content:</strong> ${data.complaint.content}</p>
                <p><strong>Complainant Email:</strong> ${data.complainant.email}</p>
                <p><strong>Complainee Email:</strong> ${data.complainee.email}</p>
                <p><strong>Date:</strong> ${data.complaint.complaintDate}</p>
                <p><strong>Time:</strong> ${data.complaint.complaintTime}</p>
            `;

                popup.style.display = 'block';
                currentComplaintId = complaintId;
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to load complaint details');
            });
    }

    function closePopup() {
        document.getElementById('complaintPopup').style.display = 'none';
    }

    function markAsReviewed() {
        // Send an AJAX request to update the status
        fetch('<?php echo ROOT; ?>/admin/updateComplaintStatus', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: currentComplaintId,
                    status: 3
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closePopup();
                    location.reload(); // Reload the page to update the lists
                } else {
                    alert('Failed to update complaint status.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating the complaint status.');
            });
    }

    function dismissComplaint() {
        // Send an AJAX request to update the status
        fetch('<?php echo ROOT; ?>/admin/updateComplaintStatus', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: currentComplaintId,
                    status: 2 // Status 2 for dismissed complaints
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closePopup();
                    location.reload(); // Reload the page to update the lists
                } else {
                    alert('Failed to dismiss complaint.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while dismissing the complaint.');
            });
    }

    let currentComplaintId = null;

    // Close popup when clicking outside
    window.onclick = function(event) {
        const popup = document.getElementById('complaintPopup');
        if (event.target === popup) {
            closePopup();
        }
    }
</script>


<?php require APPROOT . '/views/inc/footer.php'; ?>